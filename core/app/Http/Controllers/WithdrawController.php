<?php

namespace App\Http\Controllers;

use App\Trx;
use App\Wallet;
use Illuminate\Http\Request;
use App\WithdrawMethod;
use App\WithdrawLog;
use App\User;
use App\GeneralSettings;
use Illuminate\Support\Facades\Input;

class WithdrawController extends Controller
{
    public function __construct()
    {
    }
    
    public function index()
    {
        $page_title = "Withdrawal Method";
    	$withdarws = WithdrawMethod::latest()->get();
    	return view('admin.withdraw.index', compact('withdarws','page_title'));
    }

    public function store(Request $request)
    {

        $in = Input::except('_token','image');
        if($request->hasFile('image'))
        {
            $in['image'] = uniqid().'.'.$request->image->getClientOriginalExtension();
            $request->image->move('assets/images',$in['image']);
        }

        WithdrawMethod::create($in);

        return back()->with('success', 'Withdrawal Settings Updated Successfully!');
    }

    public function withdrawUpdateSettings(Request $request)
    {
        $data = WithdrawMethod::find($request->id);
        $in = Input::except('_token','image');
        if($request->hasFile('image'))
        {
            $path = 'assets/images/'.$data->image;
            if(file_exists($path)){
                @unlink($path);
            }
            $data['image'] = uniqid().'.'.$request->image->getClientOriginalExtension();
            $request->image->move('assets/images',$data['image']);
        }
        $data->fill($in)->save();
        return back()->with('success', 'Withdrawal Settings Updated Successfully!');
    }

    public function requests()
    {
    	$withdrawLog = WithdrawLog::latest()->where('status',1)->paginate(20);
        $page_title = " Withdrawal Request";
    	return view('admin.withdraw.requests', compact('withdrawLog','page_title'));
    }

    public function requestsApprove()
    {
        $bits = WithdrawLog::latest()->where('status', 2)->paginate(20);
        $page_title = " Withdrawals Approved";
        return view('admin.withdraw.history', compact('bits','page_title'));
    }

    public function requestsRefunded()
    {
        $bits = WithdrawLog::latest()->where('status', -2)->paginate(20);
        $page_title = " Withdrawals Declined";
        return view('admin.withdraw.history', compact('bits','page_title'));
    }

     public function approve(Request $request, $id)
    {
        $basic = GeneralSettings::first();
        $withdr = WithdrawLog::findorFail($id);
        $withdr['status'] = 2;
        $withdr->save();
		
		$userWallet = User::find($withdr['user_id']);
        $userWallet->balance;
        $userWallet->save();
		
		$tr = strtoupper(str_random(20));
        $trx = Trx::create([
            'user_id' => $userWallet->id,
            'amount' => $request->net_amount,
            'main_amo' => round($userWallet->balance, $basic->decimal),
            'charge' => 0,
            'type' => '+',
            'title' => 'Your Withdrawal request has been APPROVED',
            'trx' => $tr,
        ]);


        $msg =  'Your withdrawal of N' . number_format($withdr->amount) .' has been APPROVED and your account credited.' . '<br></b><br></b>Avail Bal: N' .  number_format(round($userWallet->balance))  . '' . '<br></b><br></b>Thank You for using Payonhold.' . '<br></b><br></b>For Enquiries kindly send us an Email hello@payonhold.ng or Call +234-817-581-6285 and our friendly and well trained Customer Care Representative will be glad to help. ' ;
        $txt =  'Your withdrawal of N' . number_format(round($withdr->amount)) .' has been APPROVED and your account credited.' . '\n \nAvail Bal: N' . number_format(round($userWallet->balance)) . '' . '\nThank You for using Payonhold.' . ' ' ;
        send_email($userWallet->email, $userWallet->username, 'Withdrawal APPROVED', $msg);
        send_sms($userWallet->phone, $txt);
		
        return back()->with('success', 'Withdrawal Request Approved Successfully!');
    }

    public function refundAmount(Request $request)
    {
        $basic = GeneralSettings::first();
        $withdr = WithdrawLog::findorFail($request->id);
        $withdr['status'] = -2;
        $withdr->save();

        $userWallet = User::find($withdr['user_id']);
        $userWallet->balance += $request->net_amount;
        $userWallet->save();

        $tr = strtoupper(str_random(20));
        $trx = Trx::create([
            'user_id' => $userWallet->id,
            'amount' => $request->net_amount,
            'main_amo' => round($userWallet->balance, $basic->decimal),
            'charge' => 0,
            'type' => '+',
            'title' => 'Your Withdrawal of N '.$request->net_amount .' has been DECLINED',
            'trx' => $tr,
        ]);


        $msg =  'Your withdrawal of N' . number_format($withdr->amount) .' has been DECLINED.' . '<br></b><br></b>Avail Bal: N' .  number_format(round($userWallet->balance))  . '' . '<br></b><br></b>Thank You for using Payonhold.' . '<br></b><br></b>For Enquiries kindly send us an Email hello@payonhold.ng or Call +234-817-581-6285 and our friendly and well trained Customer Care Representative will be glad to help. ' ;
        $txt =  'Your withdrawal of N' . number_format(round($withdr->amount)) .' has been DECLINED.' . '\n \nAvail Bal: N' . number_format(round($userWallet->balance)) . '' . '\nThank You for using Payonhold.' . ' ' ;
        send_email($userWallet->email, $userWallet->username, 'Withdrawal DECLINED', $msg);
        send_sms($userWallet->phone, $txt);

        return back()->with('success', 'Withdrawal DECLINED Successfully!');
    }





}
