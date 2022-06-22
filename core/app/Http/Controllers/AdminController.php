<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Exports\PayHistory;
use App\Exports\Monitoring;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Validator;
use Response;
use PDF;
use DB;
use App\Models\User;
use App\Models\DokumentasiSurvey;
use App\Models\DataAgunan;
use App\Models\Survey;
use App\Models\JenisUsaha;
use App\Models\Settings;
use App\Models\Logo;
use App\Models\Save;
use App\Models\Branch;
use App\Models\Loan;
use App\Models\Bank;
use App\Models\Currency;
use App\Models\Alerts;
use App\Models\Transfer;
use App\Models\Int_transfer;
use App\Models\Plans;
use App\Models\Adminbank;
use App\Models\Gateway;
use App\Models\Deposits;
use App\Models\Banktransfer;
use App\Models\Withdraw;
use App\Models\Withdrawm;
use App\Models\Merchant;
use App\Models\Profits;
use App\Models\Social;
use App\Models\About;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Contact;
use App\Models\Ticket;
use App\Models\Reply;
use App\Models\Review;
use App\Models\Chart;
use App\Models\Asset;
use App\Models\Exchange;
use App\Models\Buyer;
use App\Models\Seller;
use App\Models\PayLoanHistory;
use App\Models\Unit;
use App\Models\Usaha;
use App\Models\Wilayah;
use App\Models\AdminUnit;
use Illuminate\Support\Str;
use App\Models\Exttransfer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Route;

use Image;

class AdminController extends Controller
{

    public function __construct()
    {		
        $this->middleware('auth');
    }

    public function admin_unit()
    {
        $data['title'] = 'Admin Management';
        $data['admin_list'] = AdminUnit::select('admin_units.*', 'units.nama')->join('units', 'admin_units.id_unit', '=', 'units.id')->get();
        $data['unit'] = Unit::get();

        return view('admin/user/admin', $data);
    }

    public function AddAdmin(Request $request)
    {
        $dataToCreate = [
            'id_unit' => $request->unit,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ];

        $check = AdminUnit::create($dataToCreate);

        if($check) {
            return back()->with('success', 'Berhasil menambah Admin');
        } else {
            return back()->with('alert', 'Gagal menambah Admin');
        }
    }

    public function  EditAdmin($id, Request $request)
    {
        $admin = AdminUnit::whereUsername($id)->first();
        $admin->id_unit=$request->unit;
        $admin->username=$request->username;
        
        $admin->save();

        return back()->with('success', 'Berhasil menyimpan data');
    }

    public function  DeleteAdmin($id)
    {
        $admin = AdminUnit::findOrFail($id);
        $admin->delete();

        return back()->with('success', 'Berhasil menghapus data');
    }

    public function Destroyuser($id)
    {
        $user = User::findOrFail($id);
        $user->is_delete=1;

        $user->save();
        // $profit = Profits::whereUser_id($id)->delete();
        // $int_transfer = Int_transfer::whereUser_id($id)->delete();
        // $save = Save::whereUser_id($id)->delete();
        // $loan = Loan::whereUser_id($id)->delete();
        // $bank_transfer = Banktransfer::whereUser_id($id)->delete();
        // $deposit = Deposits::whereUser_id($id)->delete();
        // $alerts = Alerts::whereUser_id($id)->delete();
        // $ticket = Ticket::whereUser_id($id)->delete();
        // $withdraw = Withdraw::whereUser_id($id)->delete();
        // $bank = Bank::whereUser_id($id)->delete();
        // $asset = Asset::whereUser_id($id)->delete();
        // $exttransfer = Exttransfer::whereUser_id($id)->delete();
        // $merchant = Merchant::whereUser_id($id)->delete();
        return back()->with('success', 'User was successfully deleted');
    }  
        
    public function dashboard()
    {
        $data['title']='Dashboard';
        $data['totalusers']=User::whereIs_delete(0)->count();
        $data['blockedusers']=User::whereStatus(1)->whereIs_delete(0)->count();
        $data['activeusers']=User::whereStatus(0)->whereIs_delete(0)->count();
        $data['totalticket']=Ticket::count();
        $data['openticket']=Ticket::whereStatus(0)->count();
        $data['closedticket']=Ticket::whereStatus(1)->count();        
        $data['totalreview']=Review::count();
        $data['pubreview']=Review::whereStatus(1)->count();
        $data['unpubreview']=Review::whereStatus(0)->count();        
        $data['totaldeposit']=Deposits::count();
        $data['approveddep']=Deposits::whereStatus(1)->count();
        $data['declineddep']=Deposits::whereStatus(2)->count();
        $data['pendingdep']=Deposits::whereStatus(0)->count();        
        $data['totalbdeposit']=Banktransfer::count();
        $data['approvedbdep']=Banktransfer::whereStatus(1)->count();
        $data['declinedbdep']=Banktransfer::whereStatus(2)->count();
        $data['pendingbdep']=Banktransfer::whereStatus(0)->count();        
        $data['totalwd']=Withdraw::count();
        $data['approvedwd']=Withdraw::whereStatus(1)->count();
        $data['declinedwd']=Withdraw::whereStatus(2)->count();
        $data['pendingwd']=Withdraw::whereStatus(0)->count();        
        $data['totalloan']=Loan::whereIs_delete(0)->count();
        $data['paidloan']=Loan::whereIs_delete(0)->whereStatus(2)->count();
        $data['onholdloan']=Loan::whereIs_delete(0)->whereStatus(0)->count();
        $data['pendingloan']=Loan::whereIs_delete(0)->whereStatus(1)->count();
        $data['totalplan']=Plans::count();
        $data['appplan']=Plans::whereStatus(1)->count();
        $data['penplan']=Plans::whereStatus(0)->count();        
        $data['totalprofit']=Profits::count();
        $data['appprofit']=Profits::whereStatus(1)->count();
        $data['penprofit']=Profits::whereStatus(0)->count();
        $data['messages']=Contact::count();
        return view('admin.dashboard.index', $data);
    }    
    
    public function Users()
    {
        if(Input::get('filter')) {
            $where = [];
            if(Input::get('unit') != 0) {
                $where['id_unit'] = Input::get('unit');
            }

            if(Input::get('status') != 0) {
                $where['status'] = Input::get('status');
            }

            if(count($where) > 0) {
                $data['users']=DB::table('vsttus')->where($where)->get();
            } else {
                $data['users']=DB::table('vsttus')->get();
            }
        } else {
            $data['users']=DB::table('vsttus')->get();
        }
		$data['title']='Clients';
        $data['unit']=Unit::get();
		// $data['users']=User::whereIs_delete(0)->get();
        return view('admin.user.index', $data);
    }    
    
    public function UsersAdd()
    {
        $data['usaha'] = Usaha::whereIs_delete(0)->get();
        $data['jenis_usaha'] = JenisUsaha::whereIs_delete(0)->get();
        $data['unit'] = Unit::whereIs_delete(0)->get();
        $data['title']='Add Clients';
        $data['provinsi'] = Wilayah::whereRaw("CHAR_LENGTH(`kode`) = '2'")->orderBy('nama', 'ASC')->get();
        return view('admin.user.add_user', $data);
    }

    public function GetKota(Request $request)
    {
        $id = strlen($request->kode);
        $m = $m=($id==2?5:($id==5?8:13));
        $provinsi = Wilayah::whereRaw("LEFT(kode, " . $id . ") = '" . $request->kode . "' AND CHAR_LENGTH(kode) = '" . $m . "'")->orderBy('nama', 'ASC')->get();
        // $this->get_by_order('nama', 'ASC', ['LEFT(kode, '.$id.') = ' => $provinsi, 'CHAR_LENGTH(kode)' => $m]);

        $data_provinsi = [];
        foreach ($provinsi as $value) {
            $data_provinsi[$value->kode] = $value->nama;
        }

        $data = [
            'status' => true,
            'data' => $data_provinsi
        ];

        echo json_encode($data);
    }

    public function AddUserProcess(Request $request)
    {
        if($request) {
            $user = User::where('username', $request->username)->first();

            if(empty($user)) {
                if($request->hasFile('ktp') && $request->hasFile('usaha')) {
                    $ktp = $request->file('ktp');
                    $usaha = $request->file('usaha');
                    
                    $filename = time() . '_' . $request->username . '.jpg';
                    $location_ktp = 'asset/ktp/' . $filename;
                    $location_usaha = 'asset/usaha/' . $filename;
                    
                    Image::make($ktp)->save($location_ktp);
                    Image::make($usaha)->save($location_usaha);
                }

                $id = 0;
                $check = 0;
                if(strlen($request->jenis_usaha) > 2) {
                    $check = JenisUsaha::whereNama($request->jenis_usaha)->first();
                } else {
                    $check = JenisUsaha::whereId($request->jenis_usaha)->first();
                }

                if(!empty($check)) {
                    $id = $check->id;
                } else {
                    JenisUsaha::create([
                        'nama' => $request->jenis_usaha
                    ]);

                    $id = JenisUsaha::orderBy('id', 'DESC')->first()->id;
                }

                $data['username'] = $request->email;
                $data['password'] = Hash::make($request->password);
                $data['email'] = $request->email;
                $data['name'] = $request->nama;
                $data['tgl_lahir'] = $request->tgl_lahir;
                $data['province'] = $request->provinsi;
                $data['city'] = $request->kota;
                $data['address'] = $request->alamat;
                $data['phone'] = $request->nomor_hp;
                $data['ktp'] = $filename;
                $data['no_ktp'] = $request->no_ktp;
                $data['foto_usaha'] = $filename;
                $data['sektor_usaha'] = $request->sektor_usaha;
                $data['jumlah_anggota'] = $request->jumlah_anggota;
                $data['nama_kelompok'] = "$request->nama_kelompok";
                $data['nama_usaha'] = $request->nama_usaha;
                // $data['jumlah_omset'] = $request->omset;
                $data['status_pinjaman'] = 0;
                $data['jenis_usaha'] = $id;
                $data['unit'] = $request->unit;

                $basic = Settings::first();

                if ($basic->email_verification == 1) {
                    $email_verify = 0;
                } else {
                    $email_verify = 1;
                }

                if ($basic->sms_verification == 1) {
                    $phone_verify = 0;
                } else {
                    $phone_verify = 1;
                }

                $data['balance'] = 2;
                $data['ip_address'] = user_ip();
                $data['verification_code'] = strtoupper(Str::random(6));
                $data['acct_no'] = '2'.rand(1, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9);
                $data['sms_code'] = strtoupper(Str::random(6));
                $data['kyc_status'] = 1;
                $data['phone_verify'] = $phone_verify;
                $data['email_verify'] = $email_verify;
                $data['email_time'] = Carbon::parse()->addMinutes(5);
                $data['phone_time'] = Carbon::parse()->addMinutes(5);

                User::create($data);
                return back()->with('success', 'Berhasil Menambah Pengguna');
                
            }
            
        } return back();
    }

    public function AreaManagement()
    {
        $data['title'] = 'Area Management';
        $data['unit'] = Unit::whereIs_delete(0)->get();
        return view('admin.area.index', $data);
    }

    public function JenisManagement()
    {
        $data['title'] = 'Jenis Usaha Management';
        $data['jenis_usaha'] = JenisUsaha::whereIs_delete(0)->get();
        return view('admin.area.jenis', $data);
    }

    public function AddUnit(Request $request)
    {
        $input = [
            'nama' => $request->nama,
            'provinsi' => $request->provinsi
        ];

        Unit::create($input);

        return back()->with('success', 'Berhasil Menambah Unit');
    }

    public function EditUnit(Request $request)
    {
        $unit = Unit::whereId($request->id_unit)->first();
        $unit->nama = $request->nama;
        $unit->provinsi = $request->provinsi;

        $unit->save();

        return back()->with('success', 'Berhasil Menyimpan Perubahan');
    }

    public function DeleteUnit($id)
    {
        $data = Unit::findOrFail($id);
        $data->is_delete=1;
        $res =  $data->save();
        if ($res) {
            return back()->with('success', 'Berhasil menghapus data');
        } else {
            return back()->with('alert', 'Gagal menghapus data');
        }
    }

    public function EditJenis(Request $request)
    {
        $data = JenisUsaha::findOrFail($request->id_usaha);
        $data->nama=$request->nama;
        $data->updated_at=date('Y-m-d H:i:s');
        $res =  $data->save();
        if ($res) {
            return back()->with('success', 'Berhasil mengubah data');
        } else {
            return back()->with('alert', 'Gagal mengubah data');
        }
    }
    public function DeleteJenis($id)
    {
        $data = JenisUsaha::findOrFail($id);
        $data->is_delete=1;
        $res =  $data->save();
        if ($res) {
            return back()->with('success', 'Berhasil menghapus data');
        } else {
            return back()->with('alert', 'Gagal menghapus data');
        }
    }

    public function UsahaManagement()
    {
        $data['title'] = 'Usaha Management';
        $data['usaha'] = Usaha::whereIs_delete(0)->get();
        
        return view('admin.area.usaha', $data);
    }

    public function AddUsaha(Request $request)
    {
        Usaha::create(['nama' => $request->nama]);
        return back()->with('success', 'Berhasil Menambah Usaha');
    }

    public function EditUsaha(Request $request)
    {
        $usaha = Usaha::whereId($request->id_usaha)->first();
        $usaha->nama = $request->nama;

        $usaha->save();

        return back()->with('success', 'Berhasil Menyimpan Perubahan');
    }

    public function DeleteUsaha($id)
    {
        $data = Usaha::findOrFail($id);
        $data->is_delete=1;
        $res =  $data->save();
        if ($res) {
            return back()->with('success', 'Berhasil menghapus data');
        } else {
            return back()->with('alert', 'Gagal menghapus data');
        }
    }

    public function PrintMonitoring()
    {
        // return view('admin/user/print_monitoring');
        // exit;
        // $obj = new Monitoring();
        // return $obj->view();
        return Excel::download(new Monitoring(), 'Print Monitoring.xlsx');
    }

    public function Loanapproval()
    {
        $data['title'] = 'Awaiting Approval From Unit';
        $data['loan']=Loan::whereStatus(3)->get();

        return view('admin/loan/loanapproval', $data);
    }

    public function Loancompleted()
    {
		$data['title']='Completed loan';
		$data['loan']=Loan::whereStatus(2)->get();
        return view('admin.loan.completed', $data);
    }   
    
    public function Loandetail($id, $user_id, $state)
    {
        $data['state'] = $state;
        $data['title'] = 'Loan Detail';
        $data['pay_loan'] = PayLoanHistory::where([
            ['id_user', $user_id],
            ['id_loan', $id]
        ])->orderBy('created_at', 'ASC')->get();
        $data['loan_payed'] = PayLoanHistory::selectRaw('SUM(amount) as total')->where([
            ['id_user', $user_id],
            ['id_loan', $id]
        ])->first();
        $data['peminjam'] = User::whereId($user_id)->first();

        $data['survey'] = null;
        if($state != 1) {
            $data['survey'] = Survey::whereId_loan($id)->first();
            $data['survey_dokumentasi'] = DokumentasiSurvey::whereId_survey($data['survey']->id)->get();
        }


        $data['loan'] = Loan::whereId($id)->first();
        return view('admin.loan.detail', $data);
    }

    public function Printloan($id)
    {
        return Excel::download(new PayHistory($id), 'Histori Pembayaran.xlsx');
    }

    public function AddSurvey($id, Request $request)
    {
        $save = [
            'id_loan' => $id,
            'nama' => implode(';', $request->nama_petugas),
            'tgl_survei' => $request->tgl_survei,
            'status' => 0
        ];

        Survey::create($save);

        return back()->with('success', 'Berhasil Menambah Survey');
    }

    public function AgunanDetail($files)
    {
        $filename = $files;
        $path = 'asset/agunan/' . $filename;

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }

    public function AddLoan()
    {
        $data['title'] = 'Tambah Pinjaman';
        $data['user_list'] = User::where('kyc_status', 1)->whereIs_delete(0)->get();
        $data['usaha'] = Usaha::whereIs_delete(0)->get();
        $data['jenis_usaha'] = JenisUsaha::whereIs_delete(0)->get();
        $data['unit'] = Unit::whereIs_delete(0)->get();

        return view('admin.loan.addLoan', $data);
    }

    public function AddLoanProcess(Request $request)
    {
        if($request->hasFile('file_jaminan')) {
            $id_agunan = [];
            foreach($request->nama_jaminan as $key => $val) {
                $file = $request->file('file_jaminan');
                $filename = time() + rand(1,5) . '_' . $request->user . '.' . $file[$key]->getClientOriginalExtension();
                $file_path = 'asset/agunan/';
                $file[$key]->move($file_path, $filename);

                $data = [
                    'nama' => $val,
                    'alamat' => $request->nama_jaminan[$key],
                    'bukti' => $filename
                ];

                $rt = DataAgunan::create($data);
                $id_agunan[] = $rt->id;
            }

            $dataToInsert = [
                'user_id' => $request->user,
                'amount' => $request->jumlah,
                'jml_aset' => $request->asset,
                'jml_omset' => $request->omset,
                'id_jaminan' => implode(';', $id_agunan),
                'status' => 0,
                'tgl_diterima' => $request->tgl_proposal,
                'reference' => round(microtime(true)),
                'details' => $request->keterangan
            ];
            
            Loan::create($dataToInsert);
        }

        return back()->with('success', 'Berhasil Menambah Pinjaman');
    }

    public function payloan($id, Request $request)
    {
        $loan = Loan::whereId($id)->first();
        $username = User::find($loan->user_id)->first();

        $loan_payed = PayLoanHistory::selectRaw('SUM(amount) as total')->where([
            ['id_user', $loan->user_id],
            ['id_loan', $id]
        ])->first();

        if($request->hasFile('file_bukti')) {
            $filename = time() . '_' . $loan->id_user . '.jpg';
            $location = 'asset/bukti/' . $filename;

            Image::make($request->file_bukti)->save($location);

            // $loan_left = $loan->amount + ($loan->amount * $loan->bunga / 100);
            $loan_left = $loan->sisa_tagihan;

            if($loan_left > 0 && $request->jumlah >= $loan_left){
                // $a=$user->balance - $loan_left;
                $loan->status=2;
                // $user->balance=$a;

                $data['id_user'] = $loan->user_id;
                $data['id_loan'] = $loan->id;
                $data['amount'] = $loan_left;
                $data['tgl_bayar'] = $request->tgl_bayar;
                $data['image'] = $filename;
                // $data['date_created'] = date('Y-m-d H:i:s');
    
                // Insert into pay loan history
                PayLoanHistory::create($data);
            } else if($loan_left > 0 && $request->jumlah < $loan_left) {
                // $a = $loan->amount - $request->amount;
                // $ba = $user->balance - $request->amount;
                
                // $user->balance = $ba;
                // $loan->amount = $a;

                $data['id_user'] = $loan->user_id;
                $data['id_loan'] = $loan->id;
                $data['amount'] = $request->jumlah;
                $data['tgl_bayar'] = $request->tgl_bayar;
                $data['image'] = $filename;
                // $data['date_created'] = date('Y-m-d H:i:s');
    
                // Insert into pay loan history
                PayLoanHistory::create($data);
               
            }

            $paymentHistory = PayLoanHistory::whereRaw("MONTH(`tgl_bayar`) = '" . date('n', strtotime($request->tgl_bayar)) . "' AND YEAR(`tgl_bayar`) = '" . date('Y', strtotime($request->tgl_bayar)) . "'")->count();
            if($paymentHistory < 1) {
                $loan->sisa_tagihan = $request->sisa_bayar - $request->jumlah;
                if(strtotime($loan->last_payment) < strtotime($request->tgl_bayar)) {
                    $loan->last_payment = $request->tgl_bayar;
                }
                
                $loan->save();
            } else {
                $loan->sisa_tagihan = $loan->sisa_tagihan - $request->jumlah;
                if(strtotime($loan->last_payment) < strtotime($request->tgl_bayar)) {
                    $loan->last_payment = $request->tgl_bayar;
                }

                $loan->save();
            }
            // if(date('Y-m-d', strtotime($loan->last_payment)) < date('Y-m-d', strtotime($request->tgl_bayar))) {
            //     $loan->sisa_tagihan = $request->sisa_bayar - $request->jumlah;
            //     $loan->last_payment = $request->tgl_bayar;
            //     $loan->save();
            // }
            

            return back()->with('success', 'Loan was successfully paid.');
        } else {
            return back()->with('alert', 'File bukti harus ada');
        }
        dd($request->all());
    }
    
    public function Loanhold()
    {
		$data['title']='Unapproved loan';
		$data['loan']=Loan::whereStatus(0)->whereIs_delete(0)->get();
        return view('admin.loan.on-hold', $data);
    }     
    
    public function Loanpending()
    {
		$data['title']='Awaiting payback';
		$data['loan']=Loan::whereStatus(1)->whereIs_delete(0)->get();
        return view('admin.loan.pending', $data);
    } 
    
    public function Messages()
    {
		$data['title']='Messages';
		$data['message']=Contact::latest()->get();
        return view('admin.user.message', $data);
    }    
    
    public function Ticket()
    {
		$data['title']='Ticket system';
		$data['ticket']=Ticket::latest()->get();
        return view('admin.user.ticket', $data);
    }   
    
    public function Email($id,$name)
    {
		$data['title']='Send email';
		$data['email']=$id;
		$data['name']=$name;
        return view('admin.user.email', $data);
    }    
    
    public function Promo()
    {
		$data['title']='Send email';
        $data['client']=$user=User::all();
        return view('admin.user.promo', $data);
    } 
    
    public function Sendemail(Request $request)
    {        	
        $set=Settings::first();
        send_email($request->to, $request->name, $request->subject, $request->message);  
        $notification = array('message' => 'Mail Sent Successfuly!', 'alert-type' => 'success');
        return back()->with($notification);
    }
    
    public function Sendpromo(Request $request)
    {        	
        $set=Settings::first();
        foreach ($request->email as $email) {
            $user=User::whereEmail($email)->first();
            send_email($request->to, $user->name, $request->subject, $request->message);
        }      
        $notification = array('message' => 'Mail Sent Successfuly!', 'alert-type' => 'success');
        return back()->with($notification);
    }    
    
    public function Replyticket(Request $request)
    {        
        $data['ticket_id'] = $request->ticket_id;
        $data['reply'] = $request->reply;
        $data['status'] = 0;
        $res = Reply::create($data);      
        if ($res) {
            return back();
        } else {
            return back()->with('alert', 'An error occured');
        }
    }    
    
    public function Credit(Request $request)
    {        	
        $set=Settings::first();
        $user = User::findOrFail($request->id);	
        $a=$user->balance+$request->amount;
        $user->balance=$a;
        $user->save();
        $token = round(microtime(true));
        $content='Acct:'.$user->acct_no.', Date:'.Carbon::now().', CR Amt:'.$request->amount.',
        Bal:'.$a.', Ref:'.$token.', Desc:'.$request->content;
        $credit['user_id']=$user->id;
        $credit['amount']=$request->amount;
        $credit['details']=$content;
        $credit['type']=2;
        $credit['seen']=0;
        $credit['status']=1;
        $credit['reference']=$token;
        $res=Alerts::create($credit);
        if($set->sms_notify==1){
           send_sms($user->phone, $content);
        }    
        if($set['email_notify']==1){
           send_email($user->email, $user->username, 'Credit alert', $content);
        }      
        if ($res) {
            return back()->with('success', 'Operation successful');
        } else {
            return back()->with('alert', 'An error occured');
        }
    }    
    
    public function Debit(Request $request)
    {        	
        $set=Settings::first();
        $user = User::findOrFail($request->id);	
        $a=$user->balance-$request->amount;
        $user->balance=$a;
        $user->save();
        $token = round(microtime(true));
        $content='Acct:'.$user->acct_no.', Date:'.Carbon::now().', CR Amt:'.$request->amount.',
        Bal:'.$a.', Ref:'.$token.', Desc:'.$request->content;
        $debit['user_id']=$user->id;
        $debit['amount']=$request->amount;
        $debit['details']=$content;
        $debit['type']=1;
        $debit['seen']=0;
        $debit['status']=1;
        $debit['reference']=$token;
        $res=Alerts::create($debit);
        if($set->sms_notify==1){
           send_sms($user->phone, $content);
        }    
        if($set['email_notify']==1){
           send_email($user->email, $user->username, 'Debit alert', $content);
        }      
        if ($res) {
            return back()->with('success', 'Operation successful');
        } else {
            return back()->with('alert', 'An error occured');
        }
    }  
    
    public function Destroymessage($id)
    {
        $data = Contact::findOrFail($id);
        $data->is_delete=1;
        $res =  $data->save();
        if ($res) {
            return back()->with('success', 'Request was Successfully deleted!');
        } else {
            return back()->with('alert', 'Problem With Deleting Request');
        }
    }     
    
    public function Destroyticket($id)
    {
        $data = Ticket::findOrFail($id);
        $data->is_delete=1;
        $res =  $data->save();
        if ($res) {
            return back()->with('success', 'Request was Successfully deleted!');
        } else {
            return back()->with('alert', 'Problem With Deleting Request');
        }
    } 

    public function Manageuser($id)
    {
        $data['client']=$user=User::find($id);
        $data['title']=$user->name;
        $data['deposit']=Deposits::whereUser_id($user->id)->orderBy('id', 'DESC')->get();
        $data['bank']=Banktransfer::whereUser_id($user->id)->orderBy('id', 'DESC')->get();
        $data['withdraw']=Withdraw::whereUser_id($user->id)->orderBy('id', 'DESC')->get();
        $data['profit']=Profits::whereUser_id($user->id)->orderBy('id', 'DESC')->get();
        $data['save']=Save::whereUser_id($user->id)->orderBy('id', 'DESC')->get();
        $data['transfer']=Alerts::whereUser_id($user->id)->orderBy('id', 'DESC')->get();
        $data['loan']=Loan::whereUser_id($user->id)->orderBy('id', 'DESC')->get();
        $data['ticket']=Ticket::whereUser_id($user->id)->orderBy('id', 'DESC')->get();
        $data['bnk']=Bank::whereUser_id($user->id)->first();
        $data['sell']=Seller::whereUser_id($user->id)->orderBy('id', 'DESC')->get();
        $data['buy']=Buyer::whereUser_id($user->id)->orderBy('id', 'DESC')->get();
        $data['exchange']=Exchange::whereUser_id($user->id)->orderBy('id', 'DESC')->get();
        $data['jenis_usaha'] = JenisUsaha::get();
        $data['usaha'] = Usaha::get();
        $data['unit'] = Unit::get();

        $data['province'] = Wilayah::whereRaw("CHAR_LENGTH(`kode`) = '2'")->get();
        $id = strlen($data['client']->province);
        $m = $m=($id==2?5:($id==5?8:13));
        $data['kota'] = Wilayah::whereRaw("LEFT(kode, " . $id . ") = '" . $data['client']->province . "' AND CHAR_LENGTH(kode) = '" . $m . "'")->orderBy('nama', 'ASC')->get();
        return view('admin.user.edit', $data);
    }     
    
    public function Manageticket($id)
    {
        $data['ticket']=$ticket=Ticket::find($id);
        $data['title']='#'.$ticket->ticket_id;
        $data['client']=User::whereId($ticket->user_id)->first();
        $data['reply']=Reply::whereTicket_id($ticket->ticket_id)->get();
        return view('admin.user.edit-ticket', $data);
    }    
    
    public function Closeticket($id)
    {
        $ticket=Ticket::find($id);
        $ticket->status=1;
        $ticket->save();
        return back()->with('success', 'Ticket has been closed.');
    }     
    
    public function Blockuser($id)
    {
        $user=User::find($id);
        $user->status=1;
        $user->save();
        return back()->with('success', 'User has been suspended.');
    } 

    public function Unblockuser($id)
    {
        $user=User::find($id);
        $user->status=0;
        $user->save();
        return back()->with('success', 'User was successfully unblocked.');
    }

    public function Approvekyc($id)
    {
        $user=User::find($id);
        $user->kyc_status=1;
        $user->save();
        return back()->with('success', 'Kyc has been approved.');
    }    
    
    // Kurang penambahan balance
    public function Loanapprove($id, Request $request)
    {
        $loan=Loan::find($id);

        $loan->memo=$request->no_memo;
        $loan->tgl_memo=$request->tgl_memo;
        $loan->persetujuan=$request->no_persetujuan;
        $loan->tgl_persetujuan=$request->tgl_persetujuan;
        $loan->kontrak=$request->no_kontrak;
        $loan->tgl_kontrak=$request->tgl_persetujuan;
        $loan->rcn_penyaluran=$request->rencana_peyaluran;
        $loan->rls_penyaluran=$request->realisasi_peyaluran;
        $loan->mulai_angsuran=$request->tgl_mulai_angsuran;
        $loan->berakhir_angsuran=$request->tgl_berakhir_angsuran;
        $loan->bunga=$request->bunga_pinjaman;
        $loan->status=1;
        $loan->save();
        return back()->with('success', 'Loan has been approved.');
    }

    public function ApproveSurvey($id)
    {
        $data['survey']=Survey::find($id);
        $data['survey_dokumentasi'] = DokumentasiSurvey::whereId_survey($data['survey']->id)->get();
        $data['title']='Survey detail';
        $data['loan']=Loan::whereId($data['survey']->id_loan)->first();
        $data['dokumentasi']=DokumentasiSurvey::whereId_survey($id)->get();

        return view('admin.loan.survei_detail', $data);
        // $loan->status=1;
        // $loan->save();
        // return back()->with('success', 'Survey has been approved.');
    }

    public function KetSurvey($id, Request $request)
    {
        $survey=Survey::find($id);
        $survey->keterangan=$request->keterangan;

        $survey->save();

        return back()->with('success', 'Berhasil mengubah keterangan');
    }

    public function ApproveLoanBefore()
    {
        $data['title'] = 'Before Approve';

        return view('admin.loan.approve', $data);
    }

    public function UploadImageSurvey($id)
    {
        $input = Input::all();
		$rules = array(
            'file' => 'image|max:3000',
		);

		$validation = Validator::make($input, $rules);

		if ($validation->fails())
		{
			return Response::make($validation->errors()->first(), 400);
		}

		$file = Input::file('file');

        $extension = '.jpg';
        $directory = 'asset/survei/';
        $filename = sha1(time()) . '_' . $id .'.jpg';

        // $upload_success = true;
        // $upload_success = Input::upload('file', $directory, $filename);
        $upload_success = Image::make($file)->save($directory.$filename);

        if( $upload_success ) {
            $data['id_survey'] = $id;
            $data['gambar'] = $filename;
            DokumentasiSurvey::create($data);

            return Response::json('success', 200);
        } else {
            return Response::json('error', 400);
        }
    }

    public function Rejectkyc($id)
    {
        $user=User::find($id);
        $user->kyc_status='';
        $user->save();
        return back()->with('success', 'Kyc was successfully rejected.');
    }

    public function Profileupdate(Request $request)
    {
        $data = User::findOrFail($request->id);
        $id = 0;
        $check = 0;
        if(strlen($request->jenis_usaha) > 2) {
            $check = JenisUsaha::whereNama($request->jenis_usaha)->first();
        } else {
            $check = JenisUsaha::whereId($request->jenis_usaha)->first();
        }

        if(!empty($check)) {
            $id = $check->id;
        } else {
            JenisUsaha::create([
                'nama' => $request->jenis_usaha
            ]);

            $id = JenisUsaha::orderBy('id', 'DESC')->first()->id;
        }

        $data->username=$request->email;
        $data->name=$request->name;
        $data->tgl_lahir=$request->tgl_lahir;
        $data->phone=$request->mobile;
        $data->city=$request->city;
        $data->address=$request->address;
        $data->email=$request->email;
        $data->province = $request->provinsi;
        $data->city=$request->kota;
        // $data->ktp=$filename;
        $data->no_ktp=$request->no_ktp;
        // $data->foto_usaha=$filename;
        $data->sektor_usaha=$request->sektor_usaha;
        $data->jumlah_anggota=$request->jumlah_anggota;
        $data->nama_kelompok="$request->nama_kelompok";
        // $data->jumlah_aset=$request->asset;
        // $data->jumlah_omset=$request->omset;
        $data->status_pinjaman=0;
        $data->jenis_usaha=$id;
        $data->unit=$request->unit;
        
        if(empty($request->email_verify)){
            $data->email_verify=0;	
        }else{
            $data->email_verify=$request->email_verify;
        }    
        if(empty($request->phone_verify)){
            $data->phone_verify=0;	
        }else{
            $data->phone_verify=$request->phone_verify;
        }       
        if(empty($request->upgrade)){
            $data->upgrade=0;	
        }else{
            $data->upgrade=$request->upgrade;
        }         
        $res=$data->save();
        if ($res) {
            return back()->with('success', 'Update was Successful!');
        } else {
            return back()->with('alert', 'An error occured');
        }
    }
    
    public function LoanDestroy($id)
    {
        $data = Loan::findOrFail($id);
            $data->is_delete=1;

            $res =  $data->save();
            if ($res) {
                return back()->with('success', 'Request was Successfully deleted!');
            } else {
                return back()->with('alert', 'Problem With Deleting Request');
            }
    }

    public function logout()
    {
        Auth::guard()->logout();
        session()->flash('message', 'Just Logged Out!');
        return redirect('/admin');
    }
        
}
