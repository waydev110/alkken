<?php
require_once '../../../helper/string.php';
require_once '../../../helper/date.php';
require_once 'classConnection.php';
require_once 'classMember.php';
require_once 'classStokisMember.php';
require_once 'classSetting.php';
require_once 'classStokisDeposit.php';
require_once 'classStokisDepositDetail.php';

class classSMS
{
    private $hp_testing = '082119632854';
    private $hp_admin = '082120192008';
    private $testing = false;

    public function smsKeMember($nohptujuan, $isi_pesan)
    {
        $curl = curl_init();
        $token = "2SBGT4jzGK2jBH7wjBQq4cJdG4Fy1HO8mXsL4sXYRC7rSw6vLm3B7gR6oIALZXMP.Cc9acekT";
        $data = [
            'phone' => $nohptujuan,
            'message' => $isi_pesan,
        ];

        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, "https://tegal.wablas.com/api/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    
    private function tgljamsekarang($today)
    {
        if ($today == '') {
            return '';
        }
        return "Jam : " . $today . " \n";
    }

    private function show_ip()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        return "IP : ".$ip. " \n";
    }

    public function smsLogin($id_member)
    {

        $cm = new classMember();
        $member = $cm->detail($id_member);
        $now = date('Y-m-d H:i:s');

        $isipesan = $member->user_member.", login anda telah sukses !\n\n";
        $isipesan .= $this->tgljamsekarang($now);
        $isipesan .= $this->show_ip()." \n";
        $isipesan .= "Selalu ganti password dan PIN transaksi Anda secara berkala.\n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

    public function smsDataLogin($id_member)
    {

        $cm = new classMember();
        $member = $cm->detail($id_member);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($member->created_at);
        $isipesan .= "Berikut data anda di website *_" . $this->site_host() . "_* :\n";
        $isipesan .= $this->nama_member($member->nama_member);
        $isipesan .= $this->id_member($member->id_member);
        $isipesan .= $this->password($member->pass_member);
        $isipesan .= $this->pin($member->pin_member);
        $isipesan .= $this->wa($member->hp_member);
        $isipesan .= $this->terima_kasih();


        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

    public function smsPendaftaran($id_member)
    {

        $cm = new classMember();
        $member = $cm->detail($id_member);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($member->created_at);
        $isipesan .= $this->managemen();
        $isipesan .= $this->selamat();
        $isipesan .= $this->nama_member($member->nama_member);
        $isipesan .= $this->id_member($member->id_member);
        $isipesan .= $this->password($member->pass_member);
        $isipesan .= $this->pin($member->pin_member);
        $isipesan .= $this->wa($member->hp_member);
        $isipesan .= "Anda telah terdaftar di website *_" . $this->site_host() . "_*\n";
        $isipesan .= $this->terima_kasih();


        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }


    public function smsPendaftaranSponsor($id_member, $id_sponsor)
    {

        $cm = new classMember();
        $member = $cm->detail($id_member);
        $sponsor = $cm->detail($id_sponsor);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($member->created_at);
        $isipesan .= $this->id_member($sponsor->id_member);
        $isipesan .= $this->nama_member($sponsor->nama_member);
        $isipesan .= "Pendaftaran berhasil. Berikut data downline anda :\n\n";
        $isipesan .= $this->nama_member($member->nama_member);
        $isipesan .= $this->id_member($member->id_member);
        //   $isipesan .= $this->password($member->pass_member);
        //   $isipesan .= $this->pin($member->pin_member);
        $isipesan .= $this->wa($member->hp_member);
        $isipesan .= "\n";
        $isipesan .= $this->terima_kasih();

        $this->smsKeMember($this->testing == true ? $this->hp_testing :  $sponsor->hp_member, $isipesan);
        //   $subject = 'Pendaftaran Member';
        //   $this->emailKeMember($this->testing == true ? $this->email_testing :  $member->email_member, $subject, $isipesan);
        return true;
    }


    public function smsPendaftaranStokis($id_stokis)
    {

        $csm = new classStokisMember();
        $stokis = $csm->show($id_stokis);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($stokis->created_at);
        $isipesan .= $this->managemen();
        $isipesan .= $this->selamat();
        $isipesan .= $this->nama_stokis($stokis->nama_stokis);
        $isipesan .= $this->id_stokis($stokis->id_stokis);
        $isipesan .= $this->nama_paket($stokis->nama_paket);
        $isipesan .= $this->username($stokis->username);
        $isipesan .= $this->password($stokis->password);
        $isipesan .= $this->wa($stokis->no_handphone);
        $isipesan .= "Anda telah terdaftar di website *_" . $this->site_host() . "_*\n";
        $isipesan .= $this->terima_kasih();


        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $stokis->no_handphone, $isipesan);
    }


    public function smsDepositStokis($stokis_id, $id_deposit, $tanggal)
    {
        $csm = new classStokisMember();
        $stokis = $csm->show($stokis_id);
        $cs = new classStokisDeposit();
        $deposit = $cs->show($id_deposit);
        $csd = new classStokisDepositDetail();
        $depositDetails = $csd->index($id_deposit);

        $isipesan = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= "ID Order : *" . code_order($deposit->id, $deposit->created_at) . "*\n";
        $isipesan .= $this->id_stokis($stokis->id_stokis);
        $isipesan .= $this->nama_stokis($stokis->nama_stokis);
        $isipesan .= "Anda telah melakukan Deposit Order ";
        $isipesan .= " Sebesar : *" . rp($deposit->nominal) . "* Potongan : *" . rp($deposit->diskon) . "*\n";
        $isipesan .= " Total Bayar : *" . rp($deposit->subtotal) . "*\n";
        $isipesan .= "Detail Produk:\n";

        $no = 0;
        while ($detail = $depositDetails->fetch_object()) {
            $no++;
            $isipesan .= $no . ". *" . $detail->nama_produk_detail . "* : \n";
            $isipesan .= "  " . rp($detail->harga) . " x " . currency($detail->qty) . " = " . rp($detail->jumlah) . "\n"; // Pastikan nama field sesuai
        }
        $isipesan .= $this->terima_kasih();
        $this->smsKeMember($this->hp_admin, $isipesan);
        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $stokis->no_handphone, $isipesan);
    }
    public function smsDepositStokisNew($stokis_id, $id_deposit, $tanggal)
    {
        $cst = new classSetting();
        $csm = new classStokisMember();
        $stokis = $csm->show($stokis_id);
        $cs = new classStokisDeposit();
        $deposit = $cs->show($id_deposit);
        $csd = new classStokisDepositDetail();
        $depositDetails = $csd->index($id_deposit);
        $isipesan = "
Pesan otomatis dari " . $cst->setting('site_host') . "
🕒 " . date('Y-m-d H:i:s', strtotime($tanggal)) . "

Deposit Order:

📋 ID Order: *" . code_order($deposit->id, $deposit->created_at) . "*
🏢 ID Stokis: *" . $stokis->id_stokis . "*
👤 Nama Stokis: *" . $stokis->nama_stokis . "*
💵 Nominal Order: *" . rp($deposit->subtotal) . "*
✂️ Potongan: *" . rp($deposit->diskon) . "*
💰 Total Bayar: *" . rp($deposit->nominal) . "*

Detail Produk:
";
        $no = 0;
        while ($detail = $depositDetails->fetch_object()) {
            $no++;
            $isipesan .= "
" . $no . ". Produk: " . $detail->nama_produk . " " . $detail->total_produk . " " . $detail->satuan . "
      SKU: " . $detail->sku . "
      Nominal: " . currency($detail->qty) . "x" . rp($detail->harga) . "=" . rp($detail->jumlah) . "
      Potongan: " . rp($detail->fee_stokis) . "
      Subtotal: " . rp($detail->jumlah - $detail->fee_stokis) . "
";
        }
        $isipesan .= "\n*Terima Kasih*";
        $this->smsKeMember($this->hp_admin, $isipesan);
        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $stokis->no_handphone, $isipesan);
    }

    public function smsDepositOrderNew($stokis_id, $id_deposit, $tanggal)
    {
        $cst = new classSetting();
        $csm = new classStokisMember();
        $stokis = $csm->show($stokis_id);
        $cs = new classStokisDeposit();
        $deposit = $cs->show($id_deposit);
        $csd = new classStokisDepositDetail();
        $depositDetails = $csd->index($id_deposit);
        $isipesan = "
Pesan otomatis dari " . $cst->setting('site_host') . "
🕒 " . date('Y-m-d H:i:s', strtotime($tanggal)) . "

✅ Deposit Order Berhasil Diproses

📋 ID Order: *" . code_order($deposit->id, $deposit->created_at) . "*
🏢 ID Stokis: *" . $stokis->id_stokis . "*
👤 Nama Stokis: *" . $stokis->nama_stokis . "*
💵 Nominal: *" . rp($deposit->subtotal) . "*

Detail Produk:
";
        $no = 0;
        while ($detail = $depositDetails->fetch_object()) {
            $no++;
            $isipesan .= "
" . $no . ". Produk: " . $detail->nama_produk . " " . $detail->total_produk . " " . $detail->satuan . "
      SKU: " . $detail->sku . "
      Nominal: " . currency($detail->qty) . "x" . rp($detail->harga) . "=" . rp($detail->jumlah) . "
";
        }
        $isipesan .= "\n*Terima Kasih*";
        $this->smsKeMember($this->hp_admin, $isipesan);
        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $stokis->no_handphone, $isipesan);
    }

    public function smsTransferStokisCashback($id_stokis, $id_rekening, $keterangan, $total_transfer, $tanggal)
    {
        $cm = new classStokisMember();
        $stokis = $cm->detail($id_stokis, $id_rekening);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= $this->managemen();
        $isipesan .= $this->selamat();

        $isipesan .= $this->nama_stokis($stokis->nama_stokis);
        $isipesan .= $this->id_stokis($stokis->id_stokis);
        $isipesan .= "*" . $keterangan . "* sebesar *" . rp($total_transfer) . "* telah kami transfer ke rekening ";
        $isipesan .= "*" . $stokis->nama_bank . "* *(" . $stokis->atas_nama_rekening . ")* *" . $stokis->no_rekening . "*\n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $stokis->no_handphone, $isipesan);
    }

    public function smsBonus($id_member, $jenis_bonus, $nominal_bonus, $keterangan, $tanggal)
    {

        $cm = new classMember();
        $member = $cm->detail($id_member);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= $this->managemen();
        $isipesan .= $this->selamat();

        $isipesan .= $this->nama_member($member->nama_member);
        $isipesan .= $this->id_member($member->id_member);
        $isipesan .= "Mendapatkan bonus *" . $jenis_bonus . "* Sebesar *" . currency($nominal_bonus) . "* $keterangan di _BISNIS " . $this->site_host() . "_ \n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

    public function smsTransferBonus($id_member, $keterangan, $total_transfer, $tanggal)
    {
        $cm = new classMember();
        $member = $cm->detail($id_member);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= $this->managemen();
        $isipesan .= $this->selamat();

        $isipesan .= $this->nama_member($member->nama_member);
        $isipesan .= $this->id_member($member->id_member);
        $isipesan .= "*" . $keterangan . "* sebesar *" . rp($total_transfer) . "* telah kami transfer ke rekening ";
        $isipesan .= "*" . $member->nama_bank . "* *(" . $member->atas_nama_rekening . ")* *" . $member->no_rekening . "*\n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

    public function smsRewardPoin($id_member, $keterangan, $total_transfer, $tanggal)
    {
        $cm = new classMember();
        $member = $cm->detail($id_member);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= $this->managemen();
        $isipesan .= $this->selamat();

        $isipesan .= $this->nama_member($member->nama_member);
        $isipesan .= $this->id_member($member->id_member);
        $isipesan .= "*" . $keterangan . "* senilai *" . currency($total_transfer) . "* telah kami tambahkan ke Autosave anda.";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

    public function smsTransferPoin($id_member, $jenis_penarikan, $keterangan, $total_transfer, $tanggal)
    {
        $cm = new classMember();
        $member = $cm->detail($id_member);
        if ($jenis_penarikan == 'coin') {
            $address = "*Alexa Coin* : *" . $member->address_coin . "*\n";
            $total_transfer = $total_transfer;
        } else {
            $address = "*Akun Marketplace* : *" . $member->username_marketplace . "*\n";
            $total_transfer = currency($total_transfer);
        }

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= $this->managemen();
        $isipesan .= $this->selamat();

        $isipesan .= $this->nama_member($member->nama_member);
        $isipesan .= $this->id_member($member->id_member);
        $isipesan .= "*" . $keterangan . "* sebesar *" . $total_transfer . "* telah kami transfer ke ";
        $isipesan .= $address;
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

  
	public function smsBonusNew($id_member, $nominal_bonus, $keterangan, $tanggal) {
		
		$cm = new classMember();
		$member = $cm->detail($id_member);
        
		$isipesan  = $this->pesan_otomatis();
		$isipesan .= $this->hariini($tanggal);
		$isipesan .= $this->managemen(); 
		$isipesan .= $this->selamat();
		
		$isipesan .= $this->nama_member($member->nama_member);
		$isipesan .= $this->id_member($member->id_member);
		$isipesan .= "Mendapatkan *$keterangan* Sebesar *".currency($nominal_bonus)."* di _BISNIS ".$this->site_host()."_ \n";
		$isipesan .= $this->terima_kasih();

		return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

    public function smsOrderProses($id_member, $total_harga, $total_pin, $tanggal)
    {

        $cm = new classMember();
        $member = $cm->detail($id_member);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= $this->managemen();
        $isipesan .= $this->selamat();

        $isipesan .= $this->nama_member($member->nama_member);
        $isipesan .= $this->id_member($member->id_member);
        $isipesan .= "Belanja Produk anda berhasil diproses sebesar *Rp" . currency($total_harga) . "*\n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

    public function smsTransferReward($id_member, $reward, $tanggal)
    {

        $cm = new classMember();
        $member = $cm->detail($id_member);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= $this->managemen();
        $isipesan .= $this->selamat();

        $isipesan .= $this->nama_member($member->nama_member);
        $isipesan .= $this->id_member($member->id_member);
        $isipesan .= "Klaim Reward anda 1 Unit *" . $reward . "* telah *Disetujui*. " . $this->site_host() . "_ \n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

    public function smsCancelReward($id_member, $reward, $tanggal)
    {

        $cm = new classMember();
        $member = $cm->detail($id_member);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= $this->managemen();
        $isipesan .= $this->maaf();

        $isipesan .= $this->nama_member($member->nama_member);
        $isipesan .= $this->id_member($member->id_member);
        $isipesan .= "Klaim Reward anda 1 Unit *" . $reward . "* telah *Ditolak*. " . $this->site_host() . "_ \n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

    public function smsLupaPassword($id_member)
    {

        $cm = new classMember();
        $member = $cm->detail($id_member);
        $tanggal = date('Y-m-d H:i:s');
        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= "Anda telah melakukan permintaan lupa password di website *_" . $this->site_host() . "_*\n";
        $isipesan .= "Berikut data login anda:\n";
        $username  = $member->user_member <> '' ? $member->user_member : $member->id_member;
        $isipesan .= $this->username($username);
        $isipesan .= $this->password($member->pass_member);
        $isipesan .= $this->pin($member->pin_member);
        $isipesan .= "No Telp : " . $member->hp_member . "\n";
        $isipesan .= "Tanggal bergabung : *" . tgl_indo($member->created_at) . "*\n";
        $isipesan .= "Jam bergabung : *" . jam($member->created_at) . "*\n\n";
        $isipesan .= $this->terima_kasih();


        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }


    public function smsProsesTopup($id_member, $total_transfer, $tanggal, $status)
    {
        $cm = new classMember();
        $member = $cm->detail($id_member);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= "Permintaan Topup Saldo Autosave akun *" . $member->id_member . "* sejumlah *" . rp($total_transfer) . "* telah kami " . $status . ".\n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

    public function smsCancelBonus($id_member, $total_transfer, $tanggal)
    {

        $cm = new classMember();
        $member = $cm->detail($id_member);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= $this->maaf();

        $isipesan .= $this->nama_member($member->nama_member);
        $isipesan .= $this->id_member($member->id_member);
        $isipesan .= "Penarikan anda sebesar *" . rp($total_transfer) . "* telah *Ditolak*. " . $this->site_host() . "_ \n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

    public function smsCancelPoin($id_member, $total_transfer, $tanggal)
    {

        $cm = new classMember();
        $member = $cm->detail($id_member);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= $this->maaf();

        $isipesan .= $this->nama_member($member->nama_member);
        $isipesan .= $this->id_member($member->id_member);
        $isipesan .= "Penarikan Saldo Autosave anda sebesar *" . currency($total_transfer) . "* telah *Ditolak*. " . $this->site_host() . "_ \n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

    public function smsTransferBonusReward($id_member, $total_transfer, $tanggal)
    {
        $cm = new classMember();
        $member = $cm->detail($id_member);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= "Bonus Reward anda member *" . $member->id_member . "* sebesar *" . rp($total_transfer) . "* telah kami transfer ke rekening ";
        $isipesan .= "*" . $member->nama_bank . "* *(" . $member->atas_nama_rekening . ")* *" . $member->no_rekening . "*\n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

    public function smsBirthDay($id_member)
    {
        $cs = new classSetting();
        $cm = new classMember();
        $member = $cm->detail($id_member);

        $isipesan  = $this->managemen();
        $isipesan .= "Selamat Ulang Tahun Kepada : *" . $member->nama_member . "* yang Ke: *" . $this->hitungUsia($member->tgl_lahir_member) . "*\n\n";
        $isipesan .= $cs->setting('site_pt') . " turut senang dan bahagia merasakan hari ulang tahun Bapak/Ibu *" . $member->nama_member . "*. ";
        $isipesan .= "Semoga selalu diberikan umur panjang, sehat selalu, rezeki melimpah berkah, dan kebahagiaan yang selalu mengiringi hari-hari Bapak/Ibu *" . $member->nama_member . "* ke depannya.";
        $isipesan .= $this->terima_kasih();
        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

    public function hitungUsia($tanggal_lahir)
    {
        // Konversi tanggal lahir menjadi objek DateTime
        $tanggal_lahir_obj = new DateTime($tanggal_lahir);

        // Hitung tanggal saat ini
        $tanggal_saat_ini = new DateTime();

        // Hitung selisih tahun antara tanggal lahir dan tanggal saat ini
        $selisih_tahun = $tanggal_lahir_obj->diff($tanggal_saat_ini)->y;

        return $selisih_tahun;
    }

    public function smsDepositOrder($id_stokis, $nominal, $tanggal)
    {

        $csm = new classStokisMember();
        $stokis = $csm->show($id_stokis);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);

        $isipesan .= $this->nama_stokis($stokis->nama_stokis);
        $isipesan .= $this->id_stokis($stokis->id_stokis);
        $isipesan .= "Deposit Order anda berhasil diproses senilai *" . rp($nominal) . "*\n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $stokis->no_handphone, $isipesan);
    }

    public function smsDepositOrderReject($id_stokis, $nominal, $tanggal)
    {

        $csm = new classStokisMember();
        $stokis = $csm->show($id_stokis);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);

        $isipesan .= $this->nama_stokis($stokis->nama_stokis);
        $isipesan .= $this->id_stokis($stokis->id_stokis);
        $isipesan .= "Mohon maaf. Deposit Order anda senilai *" . rp($nominal) . "* telah ditolak.\n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $stokis->no_handphone, $isipesan);
    }

    public function smsSendOrder($id_stokis, $nominal, $tanggal)
    {

        $csm = new classStokisMember();
        $stokis = $csm->show($id_stokis);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);

        $isipesan .= $this->nama_stokis($stokis->nama_stokis);
        $isipesan .= $this->id_stokis($stokis->id_stokis);
        $isipesan .= "Stok Order berhasil ditambahkan senilai *" . rp($nominal) . "*\n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $stokis->no_handphone, $isipesan);
    }

    public function smsKirimProduk($id_member, $tanggal, $qty, $nama_jasa_ekspedisi, $no_resi, $biaya_kirim)
    {

        $cm = new classMember();
        $member = $cm->detail($id_member);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= "Pesanan anda sedang dikirim.\n\n";
        $isipesan .= $this->nama_member($member->nama_member);
        $isipesan .= $this->id_member($member->id_member);
        $isipesan .= "\n";
        $isipesan .= "Qty Produk : " . $qty . "\n";
        $isipesan .= "Jasa Pengiriman : " . $nama_jasa_ekspedisi . "\n";
        $isipesan .= "No Resi : " . $no_resi . "\n";
        $isipesan .= "Biaya Kirim : " . $biaya_kirim . "\n\n";
        $isipesan .= $this->terima_kasih();


        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

    public function smsTransferStokPengirim($id_stokis, $id_stokis_tujuan, $nominal, $detail_produk, $tanggal)
    {

        $csm = new classStokisMember();
        $stokis = $csm->show($id_stokis);
        $stokis_tujuan = $csm->show($id_stokis_tujuan);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= $this->id_stokis($stokis->id_stokis);
        $isipesan .= $this->nama_stokis($stokis->nama_stokis);
        $isipesan .= "*Transfer Stok* ke *$stokis_tujuan->nama_stokis ($stokis_tujuan->id_stokis)* senilai *" . rp($nominal) . "* berhasil diproses.\n\n";
        $isipesan .= $detail_produk . "\n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $stokis->no_handphone, $isipesan);
    }

    public function smsTransferStokPenerima($id_stokis, $id_stokis_tujuan, $nominal, $detail_produk, $tanggal)
    {

        $csm = new classStokisMember();
        $stokis = $csm->show($id_stokis);
        $stokis_tujuan = $csm->show($id_stokis_tujuan);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= $this->id_stokis($stokis_tujuan->id_stokis);
        $isipesan .= $this->nama_stokis($stokis_tujuan->nama_stokis);
        $isipesan .= "*Transfer Stok* dari *$stokis->nama_stokis ($stokis->id_stokis)* senilai *" . rp($nominal) . "* berhasil diproses.\n\n";
        $isipesan .= $detail_produk . "\n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $stokis_tujuan->no_handphone, $isipesan);
    }



    public function smsJualPinStokis($id_stokis, $id_member, $nama_plan, $qty_paket, $nominal, $detail_produk, $tanggal)
    {

        $csm = new classStokisMember();
        $cm = new classMember();
        $member = $cm->detail($id_member);
        $stokis = $csm->show($id_stokis);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= $this->id_stokis($stokis->id_stokis);
        $isipesan .= $this->nama_stokis($stokis->nama_stokis);
        $isipesan .= "*Penjualan PIN* ke *$member->nama_member ($member->id_member)* *" . $qty_paket . " paket " . $nama_plan . "* senilai *" . rp($nominal) . "* berhasil diproses.\n\n";
        $isipesan .= $detail_produk . "\n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $stokis->no_handphone, $isipesan);
    }

    public function smsJualPinMember($id_stokis, $id_member, $nama_plan, $qty_paket, $nominal, $detail_produk, $tanggal)
    {

        $csm = new classStokisMember();
        $cm = new classMember();
        $member = $cm->detail($id_member);
        $stokis = $csm->show($id_stokis);

        $isipesan  = $this->pesan_otomatis();
        $isipesan .= $this->hariini($tanggal);
        $isipesan .= $this->id_member($member->id_member);
        $isipesan .= $this->nama_member($member->nama_member);
        $isipesan .= "*Pembelian PIN* dari *$stokis->nama_stokis ($stokis->id_stokis)* *" . $qty_paket . " paket " . $nama_plan . "* senilai *" . rp($nominal) . "* berhasil diproses.\n\n";
        $isipesan .= $detail_produk . "\n";
        $isipesan .= $this->terima_kasih();

        return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }
	public function smsTransferPINPengirim($id_member, $id_member_tujuan, $nominal, $total_pin, $detail_pin, $tanggal) {
		
	    $cm = new classMember();
		$member = $cm->detail($id_member);
		$member_tujuan = $cm->detail($id_member_tujuan);

		$isipesan  = $this->pesan_otomatis();
		$isipesan .= $this->hariini($tanggal);
		$isipesan .= $this->id_member($member->id_member);
		$isipesan .= $this->nama_member($member->nama_member);
		$isipesan .= "*Transfer PIN* ke *$member_tujuan->nama_member ($member_tujuan->id_member)* senilai *".rp($nominal)."* berhasil ditransfer.\n\n";
		$isipesan .= $detail_pin."\n";
        $isipesan .= $this->terima_kasih();

		return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
	}

	public function smsTransferPINPenerima($id_member, $id_member_tujuan, $nominal, $total_pin, $detail_pin, $tanggal) {
		
	    $cm = new classMember();
		$member = $cm->detail($id_member);
		$member_tujuan = $cm->detail($id_member_tujuan);

		$isipesan  = $this->pesan_otomatis();
		$isipesan .= $this->hariini($tanggal);
		$isipesan .= $this->id_member($member_tujuan->id_member);
		$isipesan .= $this->nama_member($member_tujuan->nama_member);
		$isipesan .= "*Transfer PIN* dari *$member->nama_member ($member->id_member)* senilai *".rp($nominal)."* berhasil diterima.\n\n";
		$isipesan .= $detail_pin."\n";
        $isipesan .= $this->terima_kasih();

		return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member_tujuan->hp_member, $isipesan);
	}
	public function smsKlaimReward($id_member, $nominal_bonus, $keterangan, $tanggal) {
		
		$cm = new classMember();
		$member = $cm->detail($id_member);
        
		$isipesan  = $this->pesan_otomatis();
		$isipesan .= $this->hariini($tanggal);
		$isipesan .= $this->managemen(); 
		$isipesan .= $this->selamat();
		
		$isipesan .= $this->id_member($member->id_member);
		$isipesan .= $this->nama_member($member->nama_member);
		$isipesan .= "*$keterangan* Senilai *".rp($nominal_bonus)."* berhasil diklaim.\n\n";
		$isipesan .= $this->terima_kasih();

		return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

	public function smsKlaimAutosave($id_member, $nominal, $tanggal) {
		
		$cm = new classMember();
		$member = $cm->detail($id_member);
        
		$isipesan  = $this->pesan_otomatis();
		$isipesan .= $this->hariini($tanggal);
		$isipesan .= $this->managemen(); 
		$isipesan .= $this->selamat();
		
		$isipesan .= $this->nama_member($member->nama_member);
		$isipesan .= $this->id_member($member->id_member);
		$isipesan .= "Klaim produk Autosave senilai *".currency($nominal)."* telah berhasil. di _BISNIS ".$this->site_host()."_ \n";
		$isipesan .= $this->terima_kasih();

		return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $member->hp_member, $isipesan);
    }

	public function smsEditProfil($id_stokis, $tanggal) {
		
	    $csm = new classStokisMember();
		$stokis = $csm->show($id_stokis);

		$isipesan  = $this->pesan_otomatis();
		$isipesan .= $this->hariini($tanggal);
		$isipesan .= $this->nama_stokis($stokis->nama_stokis);
		$isipesan .= "Anda telah melakukan perubahan profil. Berikut detail Login anda.\n\n";
		$isipesan .= $this->id_stokis($stokis->id_stokis);
		$isipesan .= $this->password($stokis->password);
		$isipesan .= "Segera login ke *STOKISAREA* untuk mengecek perubahan.\n\n";
        $isipesan .= $this->terima_kasih();

		return $this->smsKeMember($this->testing == true ? $this->hp_testing :  $stokis->no_handphone, $isipesan);
	}

	public function smsPenarikanAdmin($id_member, $type, $jumlah) {
	  
		$cm = new classMember();
		$member = $cm->detail($id_member);

		$isipesan  = $this->pesan_otomatis();
		$isipesan .= $this->hariini(date('Y-m-d H:i:s', time()));
		$isipesan .= "Ada yang melakukan penarikan *".$type."* senilai *".$jumlah."*\n";
		$isipesan .= 'ID Member : '.$member->id_member."\n";
		$isipesan .= $this->nama_member($member->nama_member);
		$isipesan .= $this->terima_kasih();

        $this->smsKeMember($this->testing == true ? $this->hp_testing :  $this->hp_admin, $isipesan);
	}
    
    private function pesan_otomatis()
    {
        $cs = new classSetting();
        return "*Pesan otomatis dari " . $cs->setting('site_host') . "*\n\n";
    }

    private function hariini($today)
    {
        if ($today == '') {
            return '';
        }
        return "Pada Hari ini : *" . $today . "*\n\n";
    }

    private function managemen()
    {
        $cs = new classSetting();
        return "Segenap Managemen *_" . $cs->setting('site_pt') . "_* ";
    }

    private function selamat()
    {
        return "mengucapkan *_Selamat!_* kepada: \n\n";
    }

    private function maaf()
    {
        return "*_Mohon maaf!_* kepada: \n\n";
    }

    private function terima_kasih()
    {
        $cs = new classSetting();
        
        $terima_kasih = "untuk dapat menerima pesan WA selanjutnya\n";
        $terima_kasih .= "Harap simpan nomor ini di kontak anda\n";
        $terima_kasih .= "Harap balas dengan kata SETUJU tanpa karakter lain jika anda telah membaca pesan ini\n\n";
        $terima_kasih .= "Jika ada kendala silahkan info via\n";
        $terima_kasih .= "WA Admin: ".$cs->setting('site_phone')."\n";
        $terima_kasih .= "(Jam Kerja 09:00 - 16:00 WIB)\n\n";
        $terima_kasih .= $cs->setting('site_pt')."\n";
        $terima_kasih .= $cs->setting('site_host');
        return $terima_kasih;
    }


    private function nama_member($nama_member)
    {
        if ($nama_member == '') {
            return '';
        }
        return "Nama : *" . $nama_member . "*\n";
    }


    private function password($password)
    {
        if ($password == '') {
            return '';
        }
        return "Password Login : *" . base64_decode($password) . "*\n";
    }

    private function pin($pin)
    {
        if ($pin == '') {
            return '';
        }
        return "PIN : *" . base64_decode($pin) . "*\n";
    }

    private function username($username)
    {
        if ($username == '') {
            return '';
        }
        return "Username : *" . $username . "*\n";
    }

    private function id_member($id_member)
    {
        if ($id_member == '') {
            return '';
        }
        return "No Id : *" . $id_member . "*\n";
    }

    private function id_stokis($id_stokis)
    {
        if ($id_stokis == '') {
            return '';
        }
        return "ID STOKIS : *" . $id_stokis . "*\n";
    }
    private function nama_stokis($nama_stokis)
    {
        if ($nama_stokis == '') {
            return '';
        }
        return "NAMA STOKIS : *" . $nama_stokis . "*\n";
    }


    private function nama_paket($nama_paket)
    {
        if ($nama_paket == '') {
            return '';
        }
        return "Paket : *" . $nama_paket . "*\n";
    }

    private function wa($wa)
    {
        if ($wa == '') {
            return '';
        }
        return "No WA : *" . $wa . "*\n";
    }

    private function site_host()
    {
        $cs = new classSetting();
        return $cs->setting('site_host');
    }

    private function sitename()
    {
        $cs = new classSetting();
        return $cs->setting('sitename');
    }
}
