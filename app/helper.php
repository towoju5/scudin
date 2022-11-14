<?php


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

use App\CPU\Helpers;
use Illuminate\Support\Facades\Auth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Http\Controllers\ProductController;
use App\Model\BusinessSetting;
use App\Model\Currency;
use App\Model\OrderDetail;
use App\Model\Product;
use App\Model\Seller;
use App\Model\ShippingMethod;
use App\Model\Staff;
use App\Subscription;
use App\Units;
use App\User;
use Faker\Provider\Lorem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Vanilo\Order\Models\Order;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use FedEx\RateService\Request;
use FedEx\RateService\ComplexType;
use FedEx\RateService\SimpleType;
use Aloha\Twilio\TwilioInterface;
use Aloha\Twilio\Twilio;
use App\Model\Category;
use Carbon\Carbon as CarbonCarbon;
use Stevebauman\Location\Facades\Location;

#-------------------------------------------------------------------

if (!function_exists('twilio')) {
   function twilio($phone, $msg)
   {
      try {
         $twilio = new Twilio(getenv('TWILIO_SID'), getenv('TWILIO_TOKEN'), getenv('TWILIO_FROM'));
         if ($twilio->message($phone, $msg)) {
            return true;
         }
      } catch (\Throwable $th) {
         return $th->getMessage();
      }
      return false;
   }
}


if (!function_exists('website_title')) {
   function website_title()
   {
      $web_config = get_settings('company_name');
      echo $web_config;
   }
}


if (!function_exists('reading_time')) {
   function reading_time($the_content)
   {
      //$the_content = $post->post_content;
	  // count the number of words
	  $words = str_word_count( strip_tags( $the_content ) );
	  // rounding off and deviding per 200 words per minute
	  $minute = floor( $words / 200 );
	  // rounding off to get the seconds
	  $second = floor( $words % 200 / ( 200 / 60 ) );
	  // calculate the amount of time needed to read
	  $estimate = $minute . ' minute' . ( $minute == 1 ? '' : 's' ) . ', ' . $second . ' second' . ( $second == 1 ? '' : 's' );
	  // create output
	  $output = '<p>Estimated time: ' . $estimate . '</p>';
	  // return the estimate
	  return $output;
   }
}

if (!function_exists('get_settings')) {
   function get_settings($type)
   {
      $web_config = BusinessSetting::where('type', $type)->first();
      return $web_config->value;
   }
}

if (!function_exists('website_logo')) {
   function website_logo()
   {
      $web_logo = BusinessSetting::where(['type' => 'company_web_logo'])->pluck('value')[0];
      return $web_logo;
   }
}


if (!function_exists('get_shipping_price_by_id')) {
   function get_shipping_price_by_id($id, $weight, $height, $width, $length, $unit)
   {
      $price = ShippingMethod::find($id);
      $tt = [
         'id' => $id,
         'weight' => $weight,
         'height' => $height,
         'width' => $width,
         'length' => $length,
         'unit' => $unit,
      ];
      // var_dump($tt);
      // exit;
      if (!empty($price->cost) && $price->cost < 1) {
         return round(($price->cost * $weight), 2);
      } else {
         // check if method is UPS or Fedex
         if ($price->method == 'fedex') {
            $rate = getShippingRateFedEx($id, $weight, $height, $width, $length, $unit);
            return round(($rate * $weight), 2);
         } elseif ($price->method == 'ups') {
            $rate = getShippingRateUps($id, $weight, $height, $width, $length, $unit);
            return round(($rate * $weight), 2);
         }
         return 0;
      }
   }
}

if (!function_exists('quote_string')) {
   function quote_string($string)
   {
      return trim(str_ireplace(' ', '-', $string));
      if (str_contains(' ', $string)) {
         return "'" . $string . "'";
      }
   }
}

if (!function_exists('csvToArray')) {
   function csvToArray($filename = '', $delimiter = ',')
   {
      if (!file_exists($filename) || !is_readable($filename))
         return false;

      $header = null;
      $data = array();
      if (($handle = fopen($filename, 'r')) !== false) {
         while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
            if (!$header)
               $header = $row;
            else
               $data[] = array_combine($header, $row);
         }
         fclose($handle);
      }

      return $data;
   }
}


if (!function_exists('units')) {
   function units()
   {
      $x = Units::all(); //['kg', 'pc', 'gms', 'ltrs'];
      return $x;
   }
}

if (!function_exists('product_combinations')) {
   function product_combinations($arrays)
   {
      $result = [[]];
      foreach ($arrays as $property => $property_values) {
         $tmp = [];
         foreach ($result as $result_item) {
            foreach ($property_values as $property_value) {
               $tmp[] = array_merge($result_item, [$property => $property_value]);
            }
         }
         $result = $tmp;
      }
      return $result;
   }
}

if (!function_exists('currency_converter')) {
   function currency_converter($amount)
   {
      $usd = Currency::where(['code' => 'USD'])->first()->exchange_rate;
      $my_currency = \session('currency_exchange_rate');
      $rate = $my_currency / $usd;
      return format_price(round($amount * $rate, 2));
   }
}

//formats currency
if (!function_exists('format_price')) {
   function format_price($price)
   {
      return currency_symbol() . number_format($price, 2);
   }
}

if (!function_exists('currency_symbol')) {
   function currency_symbol()
   {
      Helpers::currency_load();
      if (\session()->has('currency_symbol')) {
         $symbol = \session('currency_symbol');
      } else {
         $system_default_currency_info = \session('system_default_currency_info');
         $symbol = $system_default_currency_info->symbol;
      }

      return $symbol;
   }
}

if (!function_exists('get_overall_rating')) {
   function get_overall_rating($reviews)
   {
      $totalRating = count($reviews);
      $rating = 0;
      foreach ($reviews as $key => $review) {
         $rating += $review->rating;
      }
      if ($totalRating == 0) {
         $overallRating = 0;
      } else {
         $overallRating = number_format($rating / $totalRating, 2);
      }

      return [$overallRating, $totalRating];
   }
}

if (!function_exists('get_products')) {
   function get_products()
   {
      return Product::all();
   }
}

if (!function_exists('productSales')) {
   function productSales($productId)
   {
      $sum = OrderDetail::where(['seller_id' => auth('seller')->id(), 'product_id' => $productId])->sum('price');
      return get_price($sum);
   }
}

if (!function_exists('get_price')) {
   function get_price($price)
   {
      return currency() . number_format(floatval($price), 2);
   }
}

if (!function_exists('currency')) {
   function currency()
   {
      return "$";
   }
}

if (!function_exists('shop_product')) {
   function shop_product()
   {
      return Product::all();
   }
}

if (!function_exists('show_datetime')) {
   function show_datetime($datetime)
   {
      return Carbon::createFromTimeStamp(strtotime($datetime))->diffForHumans();
   }
}

if (!function_exists('presentPrice')) {
   function presentPrice($price)
   {
      return @money_format('$%i', $price / 100);
   }
}

if (!function_exists('day_based_sales')) {
   function day_based_sales($days)
   {
      if ($days == 1) {
         $from = date('Y-m-d');
      } else {
         $from = date('Y-m-d', strtotime("-$days days"));
      }
      $to = date('Y-m-d');
      $query = DB::table('orders')->whereBetween('orders.created_at', [$from, $to])->join('order_details', 'orders.id', '=', 'order_details.order_id')->where('order_details.seller_id', '=', auth('seller')->id())->select(DB::raw('SUM(order_details.price) as total'))->first();
      return $query->total;
   }
}

if (!function_exists('shop')) {
   function shop()
   {
      if (auth('seller')->id()) {
         return auth('seller')->id();
      }
      if (auth('staff')->id()) {
         $shop_id = Staff::find(auth('staff')->id());
         $shop_id = $shop_id->shop_id;
         return $shop_id;
      }
   }
}


if (!function_exists('planLimit')) {
   function planLimit()
   {
      $findSeller = Seller::find(shop());
      $getPlan = Subscription::find($findSeller->plan_id);
      $getLimit = $getPlan->allowed_products;
      return $getLimit;
   }
}


if (!function_exists('checkSellerLimit')) {
   function checkSellerLimit()
   {
      $planLimit = planLimit();
      $currentSellerProducts = Product::where('user_id', shop())->count();
      if ($currentSellerProducts < $planLimit ||  $planLimit === -1) {
         return true;
      }

      return false;
   }
}

if (!function_exists('product_image')) {
   function product_image($image)
   {
      $path = '';
      $fileOrignalName = $image->getClientOriginalName();
      $filename = time() . '_' . rand(000, 99999999) . '.' . $image->getClientOriginalExtension();
      $path = public_path('storage/app/public/product/' . $filename);

      $image_resize = Image::make($image->getRealPath());
      $image_resize->resize(1000, 1000);
      $image_resize->save($path);

      // $image_resize->move($path, $filename);
      $paths = $filename;
      return $paths;
   }
}

if (!function_exists('product_thumnail_image')) {
   function product_thumnail_image($image)
   {
      $path = '';
      $fileOrignalName = $image->getClientOriginalName();
      $filename = time() . '_' . rand(000, 99999999) . '.' . $image->getClientOriginalExtension();
      $path = public_path('storage/app/public/product/' . $filename);

      $image_resize = Image::make($image->getRealPath());
      $image_resize->resize(1000, 1000);
      $image_resize->save($path);

      // $image_resize->move($path, $filename);
      $paths = $filename;
      return '/storage/app/public/product/' . $paths;
   }
}

if (!function_exists('upload_product_image')) {
   function upload_product_image($image)
   {
      $path = '';
      $fileOrignalName = $image->getClientOriginalName();
      $filename = "$fileOrignalName.$image->getClientOriginalExtension()";
      $path = public_path('storage/app/public/product/' . $filename);

      $image_resize = Image::make($image->getRealPath());
      $image_resize->resize(1000, 1000);
      $image_resize->save($path);

      // $image_resize->move($path, $filename);
      $paths = $filename;
      return $paths;
   }
}

if (!function_exists('upload_product_thumnail_image')) {
   function upload_product_thumnail_image($image)
   {
      $path = '';
      $fileOrignalName = $image->getClientOriginalName();
      $filename = time() . '_' . rand(000, 999) . '.' . $image->getClientOriginalExtension();
      $path = '/storage/app/public/thumbnail/' . $filename;


      $image_resize = Image::make($image->getRealPath());
      $image_resize->resize(300, 250);
      $image_resize->save($path);

      // $image_resize->move($path, $filename);
      $paths = $filename;
      return $path;
   }
}

if (!function_exists('shop_banner')) {
   function shop_banner($image)
   {
      // $path = '';
      $fileOrignalName = $image->getClientOriginalName();
      $filename = time() . '_' . rand(000, 999) . '.' . $image->getClientOriginalExtension();
      $path = public_path('storage/app/public/shop/banner/' . $filename);
      $image_resize = Image::make($image->getRealPath());
      $image_resize->resize(1300, 300);
      $image_resize->save($path);
      // $image_resize->move($path, $filename);
      $paths = $filename;
      return $paths;
   }
}

if (!function_exists('save_image')) {
   function save_image($path, $image)
   {
      $fileOrignalName = $image->getClientOriginalName();
      $image_path = '/storage/app/public/' . $path;
      $path = public_path($image_path);
      $filename = sha1(time()) . '.jpg';
      $image->move($path, $filename);
      $paths = $image_path . '/' . $filename;
      return $paths;
   }
}

if (!function_exists('blog_image')) {
   function blog_image($image)
   {
      $fileOrignalName = $image->getClientOriginalName();
      $filename = time() . '_' . rand(000, 999) . '.' . $image->getClientOriginalExtension();
      $path = public_path('storage/app/public/blog' . $filename);

      $image_resize = Image::make($image->getRealPath());
      $image_resize->resize(500, 500);
      $image_resize->save($path);

      $paths = $filename;
      return url("storage/app/public/blog/$paths");
   }
}

if (!function_exists('blog_url')) {
   function blog_url($title, $length = 6)
   {
      $str = Str::slug($title);
      $randomNum = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTVWXYZ"), 0, $length);
      return "$str-$randomNum";
   }
}

if (!function_exists('_limiter')) {
   function _limiter($title, $length = 6)
   {
      return $str = Str::limit($title, $length);
   }
}

if (!function_exists('recentlyViewed')) {
   function recentlyViewed()
   {
      return Product::find(session()->get('products.recently_viewed'));
   }
}

if (!function_exists('send_mail')) {
   function send_mail($user, $subject, $message, $action_url = NULL, $__name = NULL, $emailType = NULL)
   {
      //Create an instance; passing `true` enables exceptions
      $config = \App\Model\BusinessSetting::where(['type' => 'mail_config'])->first();
      $data = json_decode($config['value'], true);
      $mail = new PHPMailer(true);
      if (!auth('seller')->check()) {
         $userData = User::where('email', $user)->first();
      } else {
         $userData = Seller::where('email', $user)->first();
      }
      if (empty($userData)) {
         return false;
      }

      $template = $message;
      if (isset($__template) && !empty($__template)) {
         $template = $__template;
      }
      $location = userLocation();

      if (!empty($emailType)) {
         $template = \App\Model\BusinessSetting::where(['type' => $emailType])->first();
      }

      if (str_contains($template, '!user')) {
         $template = str_replace('!user', "$userData->l_name $userData->f_name", $template);
      }

      if (str_contains($template, '!msg')) {
         $template = str_replace('!msg', $message['msg'], $template);
      }
      if (str_contains($template, '!amount')) {
         $template = str_replace('!amount', $message['amount'], $template);
      }
      if (str_contains($template, '!IP_Address')) {
         $template = str_replace('!IP_Address', request()->ip(), $template);
      }
      if (str_contains($template, '!City_Name')) {
         $template = str_replace('!City_Name', $location['cityName'], $template);
      }
      if (str_contains($template, '!State')) {
         $template = str_replace('!State', $location['regionName'], $template);
      }
      if (str_contains($template, '!Country')) {
         $template = str_replace('!Country', $location['countryName'], $template);
      }
      if (str_contains($template, '!created_at')) {
         $template = str_replace('!created_at', CarbonCarbon::now(), $template);
      }
      if (str_contains($template, '!due_date')) {
         $template = str_replace('!due_date', CarbonCarbon::now()->addMinutes(30), $template);
      }


      $userInfo = [
         'name'      => $userData->f_name ?? $__name,
         'message'   => $template,
         'email'     => $user,
         'config'    => $config,
         'user'      => $userData,
         'subject'   => $subject ?? website_title()
      ];

      if (isset($action_url) && !empty($action_url)) {
         $userInfo['action_url'] = $action_url;
      }

      try {
         //Server settings
         //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
         $mail->isSMTP();                                            //Send using SMTP
         $mail->Host       = $data['host']; //getenv("MAIL_HOST");                     //Set the SMTP server to send through
         $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
         $mail->Username   = $data['username']; //getenv("MAIL_USERNAME");                   //SMTP username
         $mail->Password   = $data['password']; //getenv("MAIL_PASSWORD");                              //SMTP password
         $mail->SMTPSecure = $data['encryption']; //getenv("MAIL_ENCRYPTION");            //Enable implicit TLS encryption
         $mail->Port       = $data['port']; //getenv("MAIL_PORT");                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

         //Recipients
         $mail->setFrom($data['email_id'], $data['name']);
         $mail->addAddress($user);               //Name is optional

         //Content
         $mail->isHTML(true);                                  //Set email format to HTML
         $mail->Subject = $subject;
         $mail->Body    = view('mail_template', compact('userInfo'));

         $mail->send();
         return true;
      } catch (Exception $e) {
         return false;
      }
   }
}

if (!function_exists('seller_mail')) {
   /**
    * @param object $user
    * @param string $subject
    * @param string $message [html]
    */
   function seller_mail($user, $subject, $message, $action_url = NULL, $type = NULL)
   {
      //Create an instance; passing `true` enables exceptions
      $config = \App\Model\BusinessSetting::where(['type' => 'mail_config'])->first();
      $data = json_decode($config['value'], true);
      $mail = new PHPMailer(true);
      $userData = Seller::where('email', $user)->first();

      $template = $message;
      $location = userLocation();

      if (str_contains($template, '!user')) {
         $template = str_replace('!user', "$userData->l_name $userData->f_name", $template);
      }

      if (str_contains($template, '!msg')) {
         $template = str_replace('!msg', $message['msg'], $template);
      }
      if (str_contains($template, '!amount')) {
         $template = str_replace('!amount', $message['amount'], $template);
      }
      if (str_contains($template, '!IP_Address')) {
         $template = str_replace('!IP_Address', request()->ip(), $template);
      }
      if (str_contains($template, '!City_Name')) {
         $template = str_replace('!City_Name', $location['cityName'], $template);
      }
      if (str_contains($template, '!State')) {
         $template = str_replace('!State', $location['regionName'], $template);
      }
      if (str_contains($template, '!Country')) {
         $template = str_replace('!Country', $location['countryName'], $template);
      }
      if (str_contains($template, '!created_at')) {
         $template = str_replace('!created_at', CarbonCarbon::now(), $template);
      }
      if (str_contains($template, '!due_date')) {
         $template = str_replace('!due_date', CarbonCarbon::now()->addMinutes(30), $template);
      }
      if (empty($userData)) {
         $userInfo = [
            'name'      => request()->f_name,
            'message'   => $template,
            'email'     => request()->email,
            'config'    => $config,
            'user'      => [],
            'subject'   => $subject ?? website_title()
         ];
      } else {
         $userInfo = [
            'name'      => $userData->f_name,
            'message'   => $message,
            'email'     => $user,
            'config'    => $config,
            'user'      => $userData,
            'subject'   => $subject ?? website_title()
         ];
      }

      if (isset($action_url) && !empty($action_url)) {
         $userInfo['action_url'] = $action_url;
      }

      try {
         //Server settings
         // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
         $mail->isSMTP();                                            //Send using SMTP
         $mail->Host       = $data['host']; //getenv("MAIL_HOST");                     //Set the SMTP server to send through
         $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
         $mail->Username   = $data['username']; //getenv("MAIL_USERNAME");                   //SMTP username
         $mail->Password   = $data['password']; //getenv("MAIL_PASSWORD");                              //SMTP password
         $mail->SMTPSecure = $data['encryption']; //getenv("MAIL_ENCRYPTION");            //Enable implicit TLS encryption
         $mail->Port       = $data['port']; //getenv("MAIL_PORT");                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

         //Recipients
         $mail->setFrom($data['email_id'], $data['name']);
         $mail->addAddress($user);               //Name is optional

         //Content
         $mail->isHTML(true);                                  //Set email format to HTML
         $mail->Subject = $subject;
         $mail->Body    = view('mail_template', compact('userInfo'));

         $mail->send();
         return true;
      } catch (Exception $e) {
         return false;
      }
   }
}

if (!function_exists('send_user_mail')) {
   function send_user_mail($user, $subject, $message, $action_url = NULL, $__name = NULL, $emailType = NULL, $__template = NULL)
   {
      //Create an instance; passing `true` enables exceptions
      $config = \App\Model\BusinessSetting::where(['type' => 'mail_config'])->first();
      $data = json_decode($config['value'], true);
      $mail = new PHPMailer(true);

      $userData = User::where('email', $user)->first();
      if (empty($userData)) {
         return false;
      }
      $template = $message;
      if (isset($__template) && !empty($__template)) {
         $template = $__template;
      }
      $location = userLocation();

      if (!empty($emailType)) {
         $template = \App\Model\BusinessSetting::where(['type' => $emailType])->first();
      }

      if (str_contains($template, '!user')) {
         $template = str_replace('!user', "$userData->l_name $userData->f_name", $template);
      }

      if (str_contains($template, '!msg')) {
         $template = str_replace('!msg', $message['msg'], $template);
      }
      if (str_contains($template, '!amount')) {
         $template = str_replace('!amount', $message['amount'], $template);
      }
      if (str_contains($template, '!IP_Address')) {
         $template = str_replace('!IP_Address', request()->ip(), $template);
      }
      if (str_contains($template, '!City_Name')) {
         $template = str_replace('!City_Name', $location['cityName'], $template);
      }
      if (str_contains($template, '!State')) {
         $template = str_replace('!State', $location['regionName'], $template);
      }
      if (str_contains($template, '!Country')) {
         $template = str_replace('!Country', $location['countryName'], $template);
      }
      if (str_contains($template, '!created_at')) {
         $template = str_replace('!created_at', CarbonCarbon::now(), $template);
      }
      if (str_contains($template, '!due_date')) {
         $template = str_replace('!due_date', CarbonCarbon::now()->addMinutes(30), $template);
      }
      // }

      $userInfo = [
         'name'      => $userData->f_name ?? $__name,
         'message'   => $template,
         'email'     => $user,
         'config'    => $config,
         'user'      => $userData,
         'subject'   => $subject
      ];

      if (isset($action_url) && !empty($action_url)) {
         $userInfo['action_url'] = $action_url;
      }

      try {
         //Server settings
         // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
         $mail->isSMTP();                                            //Send using SMTP
         $mail->Host       = $data['host']; //getenv("MAIL_HOST");                     //Set the SMTP server to send through
         $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
         $mail->Username   = $data['username']; //getenv("MAIL_USERNAME");                   //SMTP username
         $mail->Password   = $data['password']; //getenv("MAIL_PASSWORD");                              //SMTP password
         $mail->SMTPSecure = $data['encryption']; //getenv("MAIL_ENCRYPTION");            //Enable implicit TLS encryption
         $mail->Port       = $data['port']; //getenv("MAIL_PORT");                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

         //Recipients
         $mail->setFrom($data['email_id'], $data['name']);
         $mail->addAddress($user);               //Name is optional

         //Content
         $mail->isHTML(true);                                  //Set email format to HTML
         $mail->Subject = $subject;
         $mail->Body    = view('mail_template', compact('userInfo'));

         $mail->send();
         return true;
      } catch (Exception $e) {
         return false;
      }
   }
}

if (!function_exists('money_format')) {

   function money_format($format, $number)
   {
      $regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?' .
         '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
      if (setlocale(LC_MONETARY, 0) == 'C') {
         setlocale(LC_MONETARY, '');
      }
      $locale = localeconv();
      preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
      foreach ($matches as $fmatch) {
         $value = floatval($number);
         $flags = array(
            'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ?
               $match[1] : ' ',
            'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0,
            'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
               $match[0] : '+',
            'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0,
            'isleft'    => preg_match('/\-/', $fmatch[1]) > 0
         );
         $width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
         $left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
         $right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
         $conversion = $fmatch[5];

         $positive = true;
         if ($value < 0) {
            $positive = false;
            $value  *= -1;
         }
         $letter = $positive ? 'p' : 'n';

         $prefix = $suffix = $cprefix = $csuffix = $signal = '';

         $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
         switch (true) {
            case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
               $prefix = $signal;
               break;
            case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
               $suffix = $signal;
               break;
            case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
               $cprefix = $signal;
               break;
            case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
               $csuffix = $signal;
               break;
            case $flags['usesignal'] == '(':
            case $locale["{$letter}_sign_posn"] == 0:
               $prefix = '(';
               $suffix = ')';
               break;
         }
         if (!$flags['nosimbol']) {
            $currency = $cprefix .
               ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
               $csuffix;
         } else {
            $currency = '';
         }
         $space  = $locale["{$letter}_sep_by_space"] ? ' ' : '';

         $value = number_format(
            $value,
            $right,
            $locale['mon_decimal_point'],
            $flags['nogroup'] ? '' : $locale['mon_thousands_sep']
         );
         $value = @explode($locale['mon_decimal_point'], $value);

         $n = strlen($prefix) + strlen($currency) + strlen($value[0]);
         if ($left > 0 && $left > $n) {
            $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
         }
         $value = implode($locale['mon_decimal_point'], $value);
         if ($locale["{$letter}_cs_precedes"]) {
            $value = $prefix . $currency . $space . $value . $suffix;
         } else {
            $value = $prefix . $value . $space . $currency . $suffix;
         }
         if ($width > 0) {
            $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
               STR_PAD_RIGHT : STR_PAD_LEFT);
         }

         $format = str_replace($fmatch[0], $value, $format);
      }
      return $format;
   }
}

if (!function_exists("updateDotEnv")) {
   /**
    * @param string $key, $newValue
    */
   function updateDotEnv($key, $newValue, $delim = '')
   {

      $path = base_path('.env');
      // get old value from current env
      $oldValue = env($key);

      // was there any change?
      if ($oldValue === $newValue) {
         return;
      }

      // rewrite file content with changed data
      if (file_exists($path)) {
         // replace current value with new value 
         file_put_contents(
            $path,
            str_replace(
               $key . '=' . $delim . $oldValue . $delim,
               $key . '=' . $delim . $newValue . $delim,
               file_get_contents($path)
            )
         );
      }
   }
}

if (!function_exists("validate_address")) {
   /**
    * @param array address_line1, city, state, postal_code, country_code
    */
   function validate_address($data)
   {
      $accessKey = env("UPS_ACCESS_KEY");
      $userId = env("UPS_USER_ID");
      $password = env("UPS_PASSWORD");

      $address = new \Ups\Entity\Address();
      $address->setAttentionName('Test Test');
      $address->setBuildingName('Test');

      $address->setAddressLine1($data['address']);
      $address->setCity($data['city']);
      $address->setCountryCode($data['country']);
      $address->setStateProvinceCode($data['state']);
      $address->setPostalCode($data['postal']);

      $xav = new \Ups\AddressValidation($accessKey, $userId, $password);
      $xav->activateReturnObjectOnValidate(); //This is optional
      try {
         $response = $xav->validate($address, $requestOption = \Ups\AddressValidation::REQUEST_OPTION_ADDRESS_VALIDATION, $maxSuggestion = 15);
         return true;
      } catch (Exception $e) {
         $error = json_encode($e);
         return $e;
      }
   }
}

if (!function_exists('getShippingRateFedEx')) {
   function getShippingRateFedEx($method, $weight = 150, $height = 10, $width = 10, $length = 10, $unit = 10)
   {
      return 0;
      $rateRequest = new ComplexType\RateRequest();
      $userAddress = DB::table('shipping_addresses')->find(request()->input('shipping_method_id'));
      $_method = ShippingMethod::find($method);

      //authentication & client details
      $rateRequest->WebAuthenticationDetail->UserCredential->Key = env("FEDEX_KEY");
      $rateRequest->WebAuthenticationDetail->UserCredential->Password = env("FEDEX_PASSWORD");
      $rateRequest->ClientDetail->AccountNumber = env("FEDEX_ACCOUNT_NUMBER");
      $rateRequest->ClientDetail->MeterNumber = env("FEDEX_METER_NUMBER");

      $rateRequest->TransactionDetail->CustomerTransactionId = sha1('testing rate service request');

      //version
      $rateRequest->Version->ServiceId = 'crs';
      $rateRequest->Version->Major = 24;
      $rateRequest->Version->Minor = 0;
      $rateRequest->Version->Intermediate = 0;

      $rateRequest->ReturnTransitAndCommit = true;

      //shipper
      $rateRequest->RequestedShipment->PreferredCurrency = 'USD';
      $rateRequest->RequestedShipment->Shipper->Address->StreetLines = [$_method->address];
      $rateRequest->RequestedShipment->Shipper->Address->City = $_method->city;
      $rateRequest->RequestedShipment->Shipper->Address->StateOrProvinceCode = $_method->state;
      $rateRequest->RequestedShipment->Shipper->Address->PostalCode = $_method->postal;
      $rateRequest->RequestedShipment->Shipper->Address->CountryCode = $_method->country;

      //recipient
      $rateRequest->RequestedShipment->Recipient->Address->StreetLines = [$userAddress['address']];
      $rateRequest->RequestedShipment->Recipient->Address->City = $userAddress['city'];
      $rateRequest->RequestedShipment->Recipient->Address->StateOrProvinceCode = $userAddress['state'];
      $rateRequest->RequestedShipment->Recipient->Address->PostalCode = $userAddress['postal'];
      $rateRequest->RequestedShipment->Recipient->Address->CountryCode = $userAddress['country'];

      //shipping charges payment
      $rateRequest->RequestedShipment->ShippingChargesPayment->PaymentType = SimpleType\PaymentType::_SENDER;

      //rate request types
      $rateRequest->RequestedShipment->RateRequestTypes = [SimpleType\RateRequestType::_PREFERRED, SimpleType\RateRequestType::_LIST];

      $rateRequest->RequestedShipment->PackageCount = 2;

      //create package line items
      $rateRequest->RequestedShipment->RequestedPackageLineItems = [new ComplexType\RequestedPackageLineItem(), new ComplexType\RequestedPackageLineItem()];

      //package 1
      $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Value = 2;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Units = SimpleType\WeightUnits::_LB;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Length = 10;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Width = 10;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Height = 3;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Units = SimpleType\LinearUnits::_IN;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->GroupPackageCount = 1;

      //package 2
      $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Value = 5;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Units = SimpleType\WeightUnits::_LB;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Length = 20;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Width = 20;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Height = 10;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Units = SimpleType\LinearUnits::_IN;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->GroupPackageCount = 1;

      $rateServiceRequest = new Request();
      //$rateServiceRequest->getSoapClient()->__setLocation(Request::PRODUCTION_URL); //use production URL

      $rateReply = $rateServiceRequest->getGetRatesReply($rateRequest); // send true as the 2nd argument to return the SoapClient's stdClass response.


      if (!empty($rateReply->RateReplyDetails)) {
         foreach ($rateReply->RateReplyDetails as $rateReplyDetail) {
            var_dump($rateReplyDetail->ServiceType);
            if (!empty($rateReplyDetail->RatedShipmentDetails)) {
               foreach ($rateReplyDetail->RatedShipmentDetails as $ratedShipmentDetail) {
                  var_dump($ratedShipmentDetail->ShipmentRateDetail->RateType . ": " . $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Amount);
               }
            }
            echo "<hr />";
         }
      }
      return 0;
      // var_dump($rateReply);
      // return $dd[] = ($rateReply);
   }
}

if (!function_exists('getShippingRateUps')) {
   function getShippingRateUps($method, $weight = 150, $height = 10, $width = 10, $length = 10, $unit = 10)
   {
      $accessKey = env("UPS_ACCESS_KEY");
      $userId = env("UPS_USER_ID");
      $password = env("UPS_PASSWORD");
      $rate = new Ups\Rate($accessKey, $userId, $password);

      $_method = ShippingMethod::find($method);
      $userAddress = [];
      $data = session('customer_info');
      $userAddress = DB::table('shipping_addresses')->find($data['address_id']);


      try {
         $shipment = new \Ups\Entity\Shipment();
         $_user = User::find(auth('customer')->id());

         $shipperAddress = $shipment->getShipper()->getAddress();
         $shipperAddress->setPostalCode($_method->postal);

         #----- Sellers Address -----#
         $address = new \Ups\Entity\Address();
         $address->setAddressLine1($_method->address);
         $address->setCity($_method->city);
         $address->setStateProvinceCode($_method->state);
         $address->setPostalCode($_method->postal);
         $address->setCountryCode($_method->country);
         // $address->setPostalCode('99205');
         $shipFrom = new \Ups\Entity\ShipFrom();
         $shipFrom->setAddress($address);
         $shipment->setShipFrom($shipFrom);

         #----- Receivers Address -----#
         $shipTo = $shipment->getShipTo();
         $shipTo->setCompanyName('Test Ship To');
         $shipToAddress = $shipTo->getAddress();
         $shipToAddress->setAddressLine1($userAddress->address);
         $shipToAddress->setCity($userAddress->city);
         $shipToAddress->setCountryCode($userAddress->country);
         $shipToAddress->setStateProvinceCode($userAddress->state);
         $shipToAddress->setPostalCode($userAddress->zip);

         #----- Package Info -----#
         $package = new \Ups\Entity\Package();
         $package->getPackagingType()->setCode(\Ups\Entity\PackagingType::PT_PACKAGE);
         $package->getPackageWeight()->setWeight($weight);

         // // if you need this (depends of the shipper country)
         // $weightUnit = new \Ups\Entity\UnitOfMeasurement;
         // $weightUnit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_KGS);
         // $package->getPackageWeight()->setUnitOfMeasurement($weightUnit);

         ### $weight, $height, $width, $length, $unit
         $dimensions = new \Ups\Entity\Dimensions();
         $dimensions->setHeight($height);
         $dimensions->setWidth($width);
         $dimensions->setLength($length);

         $unit = new \Ups\Entity\UnitOfMeasurement;
         $unit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_IN);

         $dimensions->setUnitOfMeasurement($unit);
         $package->setDimensions($dimensions);

         $shipment->addPackage($package);

         error_log(json_encode($shipment));
         $result = ($rate->getRate($shipment));
         // var_dump($result); exit;
         if ($result->RatedShipment) {
            return ($result->RatedShipment[0]->TotalCharges->MonetaryValue);
         } else {
            return json_encode(['Error: ' => $result]);
         }
      } catch (Exception $e) {
         var_dump($e);
      }
   }
}

if (!function_exists('getPlanById')) {
   function getPlanById($planId)
   {
      return $plan = Subscription::find($planId);
   }
}

if (!function_exists('getUserPlan')) {
   function getUserPlan($userId = null)
   {
      if (null != $userId) {
         $user = User::find('id', $userId)->first();
         return $user->plan_id;
      }
      return "";
   }
}

if (!function_exists('userLocation')) {
   function userLocation()
   {
      if (request()->ip() == '127.0.0.1') {
         $_ip = "105.112.227.138";
      } else {
         $_ip = request()->ip();
      }
      $currentUserInfo = Location::get($_ip);
      $location['ip'] = $currentUserInfo->ip;
      $location['countryName'] = $currentUserInfo->countryName;
      $location['countryCode'] = $currentUserInfo->countryCode ?? $currentUserInfo->countryName;
      $location['regionCode'] = $currentUserInfo->regionCode ?? $currentUserInfo->regionName;
      $location['regionName'] = $currentUserInfo->regionName;
      $location['cityName'] = $currentUserInfo->cityName;
      $location['zipCode'] = $currentUserInfo->zipCode;
      $location['latitude'] = $currentUserInfo->latitude;
      $location['longitude'] = $currentUserInfo->longitude;
      $location['address'] = "$currentUserInfo->regionName $currentUserInfo->countryName";
      session()->put('location', $location);
      return $location;
   }
}

if (!function_exists('productBySlug')) {
   function productBySlug($slug)
   {
      $product = Product::where('slug', $slug)->first();
      return $product;
   }
}

if (!function_exists('getShippingMethod')) {
   function getShippingMethod($id)
   {
      $shipMethod = ShippingMethod::find($id);
      return $shipMethod->title;
   }
}

if (!function_exists('getEthosPlanById')) {
   function getEthosPlanById($planId)
   {
      if ($planId == null) {
         return false;
      }
      $plan = Subscription::find($planId);
      if (strpos(strtolower($plan->plan_name), 'ethos') !== false) {
         return true;
      } else {
         return false;
      }
   }
}

if (!function_exists('check_ethos')) {
   function check_ethos($seller_id)
   {
      if (null != $seller_id) {
         $seller = Seller::find($seller_id)->first();
         if (getEthosPlanById($seller->plan_id) !== true) {
            if (null != auth('customer')->id()) {
               $user = User::find(auth('customer')->id())->first();
               if (getEthosPlanById($user->plan_id) !== true) {
                  return false;
               }
            }
         }
         return true;
      }
      return false;
   }
}

if (!function_exists('getFinalPrice')) {
   function getFinalPrice($collection, $i)
   {
      $new_collection = $collection->map(function ($item, $key) use (&$i) {
         if ($key == $i) {
            // var_dump($item); exit;
            $product = Product::find($item['id']);
            $_id = $item['shipping_method_id'];
            $item['shipping_cost'] = get_shipping_price_by_id($_id, $product['weight'], $product['height'], $product['width'], $product['length'], $product['unit']);
            // var_dump($item['shipping_cost']); exit;
         }
         return $item;
      });

      return $new_collection;
   }
}

if (!function_exists('_getTransactionId')) {
   /**
    * return uuid()
    */
   function _getTransactionId()
   {
      return sprintf(
         '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

         // 32 bits for "time_low"
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff),

         // 16 bits for "time_mid"
         mt_rand(0, 0xffff),

         // 16 bits for "time_hi_and_version",
         // four most significant bits holds version number 4
         mt_rand(0, 0x0fff) | 0x4000,

         // 16 bits, 8 bits for "clk_seq_hi_res",
         // 8 bits for "clk_seq_low",
         // two most significant bits holds zero and one for variant DCE1.1
         mt_rand(0, 0x3fff) | 0x8000,

         // 48 bits for "node"
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff)
      );
   }
}

if (!function_exists('get_commission')) {
   /**
    * return uuid()
    */
   function get_commission($product_id)
   {
      $commission = 0;
      // Grab category info via charge_cat
      $product = Product::find($product_id);
      $p_cat = Category::find($product->charge_cat);
      if(empty($p_cat->commision_type)) return 0;
      if ($p_cat->commision_type == 'combined_fee') {
            // calculate the percentage and add to flat fee
         $commission = ((($product->unit_price / 100) * $p_cat->percentage) + $p_cat->flat);
      } elseif ($p_cat->commision_type == 'flat_fee') {
         $commission = $p_cat->flat;
      } elseif ($p_cat->commision_type == 'percentage') {
         $commission = (($product->unit_price / 100) * $p_cat->percentage);
      }
      return $commission;
   }
}

