<?php

namespace App\Http\Controllers;

use App\Trx;
use App\Wallet;
use App\WithdrawLog;
use Illuminate\Http\Request;
use Auth;
use App\GeneralSettings;
use App\User;
use App\Admin;
use App\UserLogin;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use File;
use Image;
use App\Deposit;


class GeneralSettingController extends Controller
{

	public function __construct(){
		$Gset = GeneralSettings::first();
		$this->sitename = $Gset->sitename;
	}
	public function index(){
		$data['page_title'] = "Basic Settings";
		return view('admin.loginform', $data);
	}
	public function GenSetting(){
		$data['page_title'] = 'General Settings';
			$data['general'] = GeneralSettings::first();
		return view('admin.webcontrol.general', $data);
	}

	public function UpdateGenSetting(Request $request)
    {
        $request->validate([

            'currency' => 'required',
            'sitename' => 'required',
            'decimal' => 'required|integer|min:1',
        ]);

        $gs = GeneralSettings::first();
        $in = Input::except('_token');
        $in['color'] = ltrim($request->color,'#');
        $in['registration'] = $request->registration == 'on' ? '1' : '0';
        $in['email_verification'] = $request->email_verification == 'on' ? '1' : '0';
        $in['sms_verification'] = $request->sms_verification == 'on' ? '1' : '0';
        $in['email_notification'] = $request->email_notification == 'on' ? '1' : '0';
        $in['sms_notification'] = $request->sms_notification == 'on' ? '1' : '0';
        $res = $gs->fill($in)->save();

			if ($res) {
				return back()->with('success', 'Updated Successfully!');
			}else{
				return back()->with('alert', 'Problem With Updating');
			}
	}


    public function changePassword()
    {
        $data['page_title'] = "Change Password";
        return view('admin.webcontrol.change_password',$data);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'password_confirmation' => 'required|same:new_password',
        ]);

        $user = Auth::guard('admin')->user();

        $oldPassword = $request->old_password;
        $password = $request->new_password;
        $passwordConf = $request->password_confirmation;

        if (!Hash::check($oldPassword, $user->password) || $password != $passwordConf) {
            $notification =  array('message' => 'Password do not match !!', 'alert-type' => 'error');
            return back()->with($notification);
        }elseif (Hash::check($oldPassword, $user->password) && $password == $passwordConf)
        {
            $user->password = bcrypt($password);
            $user->save();
            $notification =  array('message' => 'Password Changed Successfully !!', 'alert-type' => 'success');
            return back()->with($notification);
        }
    }


    public function profile()
    {
        $data['admin'] = Auth::user();
        $data['page_title'] = "Profile Settings";
        return view('admin.webcontrol.profile',$data);
    }

    public function updateProfile(Request $request)
    {
        $data = Admin::find($request->id);
        $request->validate([
            'name' => 'required|max:20',
            'email' => 'required|max:50|unique:admins,email,'.$data->id,
            'mobile' => 'required|regex:/(01)[0-9]{9}/',
        ]);

        $in = Input::except('_method','_token');
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = 'admin_'.time().'.jpg';
            $location = 'assets/admin/img/' . $filename;
            Image::make($image)->resize(300,300)->save($location);
            $path = './assets/admin/img/';
            File::delete($path.$data->image);
            $in['image'] = $filename;
        }
        $data->fill($in)->save();

        $notification =  array('message' => 'Profile Updated Successfully', 'alert-type' => 'success');
        return back()->with($notification);
    }


    public function users()
    {
        $data['page_title'] = "User Manage";
        $data['users'] = User::latest()->paginate(20);
        return view('admin.users.index', $data);
    }

    public function userSearch(Request $request)
    {
        $this->validate($request,
            [
                'search' => 'required',
            ]);
        $data['users'] = User::where('username', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%')->orWhere('name', 'like', '%' . $request->search . '%')->get();
        $data['page_title'] = "Search User";
        return view('admin.users.search', $data);
    }

    public function singleUser($id)
    {
        $user = User::findorFail($id);
        $data['page_title'] = "User Manage";
        $data['user'] = $user;
        $data['last_login'] = UserLogin::whereUser_id($user->id)->orderBy('id', 'desc')->first();
        return view('admin.users.single', $data);
    }

    public function userPasschange(Request $request, $id)
    {
        $user = User::find($id);
        $this->validate($request,
            [
                'password' => 'required|string|min:5|confirmed'
            ]);
        if ($request->password == $request->password_confirmation) {
            $user->password = bcrypt($request->password);
            $user->save();
            $msg = 'Your Password has been successfully Changed By Payonhold. <br></b><br></b>New Password is: ' . $request->password . '<br></b><br></b>Thank You for using Payonhold.' . '<br></b><br></b>For Enquiries kindly send us an Email hello@payonhold.ng or Call +234-817-581-6285 and our friendly and well trained Customer Care Representative will be glad to help. ' ;;
            send_email($user->email, $user->username, 'Password Changed successfully', $msg);

            $notification = array('message' => 'Password Changed successfully', 'alert-type' => 'success');
            return back()->with($notification);
        } else {
            $notification = array('message' => 'Password do not match', 'alert-type' => 'error');
            return back()->with($notification);
        }
    }


    public function statupdate(Request $request, $id)
    {
        $user = User::find($id);
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:255|unique:users,phone,' . $user->id,
        ]);
        $in = Input::except('_token', '_method');
        $user['status'] = $request->status == "1" ? 1 : 0;
        $user['email_verify'] = $request->email_verify == "1" ? 1 : 0;
        $user['phone_verify'] = $request->phone_verify == "1" ? 1 : 0;
        $user->fill($in)->save();

        $msg = 'Your Profile Updated by Admin';
        send_email($user->email, $user->username, 'Profile Updated', $msg);

        $notification = array('message' => 'User Profile Updated Successfully!', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function userEmail($id)
    {
        $data['user'] = User::findorFail($id);
        $data['page_title'] = "Send  Email To User";
        return view('admin.users.email', $data);
    }

    public function sendemail(Request $request)
    {

        $this->validate($request,
            [
                'emailto' => 'required|email',
                'reciver' => 'required',
                'subject' => 'required',
                'emailMessage' => 'required'
            ]);
        $to = $request->emailto;
        $name = $request->reciver;
        $subject = $request->subject;
        $message = $request->emailMessage;

        send_email($to, $name, $subject, $message);
        $notification = array('message' => 'Mail Sent Successfully!', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function banusers()
    {
        $data['page_title'] = "Banned User";
        $data['users'] = User::where('status', '0')->orderBy('id', 'desc')->paginate(10);
        return view('admin.users.banned', $data);
    }

    public function loginLogsByUsers($id)
    {
        $user =  User::find($id);
        $logs = UserLogin::where('user_id', $id)->orderBy('id', 'DESC')->paginate(30);
        $page_title = 'Login Information';
        return view('admin.users.login-logs-by-users', compact('logs', 'page_title','user'));
    }
    public function ManageBalanceByUsers($id)
    {
        $user =  User::find($id);
        $page_title = "TOP-UP / DEDUCT BALANCE";
        return view('admin.users.balance-manage', compact('user', 'page_title'));
    }

    public function saveBalanceByUsers(Request $request)
    {
        $basic = GeneralSettings::first();

        $user = User::find($request->id);
        $this->validate($request, [
            'amount' => 'required|numeric|min:0',
            'message' => 'required'
        ]);

        if($request->operation == "on")
        {
            $user->balance += $request->amount;
            $user->save();

        $txt = 'Your account has been Credited with an Instant Top-Up of N'. number_format($request->amount) . ''. '\n \nAvail Bal: N' . number_format(round($user->balance)) . '' . '\n\nThank You for using Payonhold.' . ' ' ;
        $msg = 'We wish to notify you that your account has been CREDITED with an Instant Top-Up of N'. number_format($request->amount) . ''. '<br></b><br></b>Avail Bal: N' .  number_format(round($user->balance))  . '' . '<br></b><br></b>Thank You for using Payonhold.' . '<br></b><br></b>For Enquiries kindly send us an Email hello@payonhold.ng or Call +234-817-581-6285 and our friendly and well trained Customer Care Representative will be glad to help. ' ;
        send_email($user->email, $user->username, 'Instant TOP-UP ', $msg);
        send_sms($user->phone, $txt);
        }else{
            if(($user->balance >0) && ($request->amount < $user->balance) )
            {
                $user->balance -= $request->amount;
                $user->save();

                $txt = 'The sum of N'. number_format($request->amount) . ' has been Debited from your Payonhold account.'.  '\n \nAvail Bal: N' . number_format(round($user->balance)) . '' . '\n\nThank You for using Payonhold.' . ' ' ;
                $msg = 'We wish to notify you that your account has been DEBITED of N'. number_format($request->amount) . ' by Payonhold.' . '<br></b><br></b>Avail Bal: N' .  number_format(round($user->balance))  . '' . '<br></b><br></b>Thank You for using Payonhold.' . '<br></b><br></b>For complaints kindly send us an Email complaints@payonhold.ng or Call +234-817-581-6285 and our friendly and well trained Customer Care Representative will be glad to help. ' ;
                send_email($user->email, $user->username, 'Instant DEBIT ', $msg);
                send_sms($user->phone, $txt);

            }else{
                return back()->with('alert', 'Insufficient Balance!');
            }
        }

        return back()->with('success', 'Account Operation Successful!');
    }


    public function loginLogs($user = 0)
    {
        $user = User::find($user);
        if ($user) {
            $logs = UserLogin::where('user_id', $user->id)->orderBy('id', 'DESC')->paginate(20);
            $page_title = 'Login Logs Of ' . $user->name;
        } else {
            $logs = UserLogin::orderBy('id', 'DESC')->paginate(20);
            $page_title = 'User Login Logs';
        }
        return view('admin.users.login-logs', compact('logs', 'page_title'));
    }


    public function userTrans($id)
    {
        $user = User::find($id);
        $page_title = "$user->username - All Transaction";
        $deposits = Trx::whereUser_id($id)->paginate(30);
        return view('admin.users.user-trans', compact('deposits', 'page_title'));
    }
    public function userDeposit($id)
    {
        $user = User::find($id);
        $page_title = "$user->username - All Deposit";
        $deposits = Deposit::whereUser_id($id)->whereStatus(1)->latest()->paginate(30);
        return view('admin.users.user-deposit-log', compact('deposits', 'page_title'));
    }
    public function userWithdraw($id)
    {
        $user = User::find($id);
        $page_title = "$user->username - All Withdrawal Request";
        $deposits = WithdrawLog::whereUser_id($id)->where('status','!=',0)->latest()->paginate(30);
        return view('admin.users.user-withdraw', compact('deposits', 'page_title'));
    }





}
