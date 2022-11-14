<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use App\Model\Seller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function index()
    {
        return view('admin-views.business-settings.mail.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            "name" => 'required',
            "host" => 'required',
            "driver" => 'required',
            "port" => 'required',
            "username" => 'required',
            "email" => 'required',
            "encryption" => 'required',
            "password" => 'required',
        ]);
        BusinessSetting::where(['type' => 'mail_config'])->update([
            'value' => json_encode([
                "name" => $request['name'],
                "host" => $request['host'],
                "driver" => $request['driver'],
                "port" => $request['port'],
                "username" => $request['username'],
                "email_id" => $request['email'],
                "encryption" => $request['encryption'],
                "password" => $request['password']
            ])
        ]);
        $__data = [
            'MAIL_MAILER'   =>  $request['driver'],
            'MAIL_HOST' =>  $request['host'],
            'MAIL_PORT' =>  $request['port'],
            'MAIL_USERNAME' =>  $request['username'],
            'MAIL_PASSWORD' =>  $request['password'],
            'MAIL_ENCRYPTION'   =>  $request['encryption'],
            'MAIL_FROM_ADDRESS' =>  $request['email'],
            'MAIL_FROM_NAME'    =>  $request['name'],
        ];
        foreach ($__data as $key => $value) {
            // if (str_contains($value, '@')) {
            //     $value = "try-again man";
            // }
            updateDotEnv($key, $value);
        }
        Toastr::success('Configuration updated successfully!');
        return back();
    }

    /**
     * Send Email to Users
     */

     public function Sellersend_mail(Request $request)
     {
        // single seller
        if($request->has('single_receiver') && ($request->receiver != NULL)){
            $user = Seller::where('email', $request->receiver);
            if(seller_mail($request->receiver, $request->subject, $request->message)){
                Toastr::success("Mail Sent Successfully");
                return back();
            }
        }
        $users = Seller::where('is_email_verified', 1)->get();
        $title = "Send Mail to Seller";
        $route = 'admin.seller.send.mail';
        return view('admin-views.business-settings.mail.single', compact(['users', 'title', 'route']));
     }

    /**
     * Send Email to Users
     */

     public function Usersend_mail(Request $request)
     {
        if($request->has('single_receiver') && ($request->receiver != NULL)){
            $user = User::where('email', $request->receiver);
            if(send_user_mail($request->receiver, $request->subject, $request->message)){
                Toastr::success("Mail Sent Successfully");
                return back();
            }
            Toastr::info("Action Completed Successfully");
            return back();
        }
        $users = User::where('is_email_verified', 1)->get();
        $title = "Send Mail to User";
        $route = 'admin.user.send.mail';
        return view('admin-views.business-settings.mail.single', compact(['users', 'title', 'route']));
     }

    /**
     * Send Email to All Users/Sellers
     */

     public function send_mail(Request $request)
     {
        if($request->has('receiver') && ($request->receiver == 'sellers')){
            $sellers = Seller::all();
            foreach ($sellers as $seller) {
                seller_mail($seller->email, $request->subject, $request->message);
            }
            Toastr::info("Action Completed Successfully");
            return back();
        }
        
        if($request->has('receiver') && ($request->receiver == 'users')){
            $users = User::all();
            foreach ($users as $user) {
                send_user_mail($user->email, $request->subject, $request->message);
            }
            Toastr::info("Action Completed Successfully");
            return back();
        }
        return view('admin-views.business-settings.mail.system');
     }
}
