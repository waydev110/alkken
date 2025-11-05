<?php
require_once '../../../helper/string.php';
require_once '../../../helper/setting.php';
require_once 'Member.php';
require_once 'StokisMember.php';

class SMS
{
    private $hp_testing = '6285862837654';
    private $testing = false;

    private function sendSms($phone, $message)
    {
        $curl = curl_init();
        $token = "khWt3afXcFkIr2RfjK13aSUvGly5MzXZaGztrE97IemPMP8TzKetEJq.z8ppWwDy";
        $data = [
            'phone' => $phone,
            'message' => $message,
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: $token",
        ]);
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

    private function formatMessage($messageType, $data, $date)
    {
        $message = $this->pesan_otomatis();
        $message .= $this->hariini($date);
        $message .= $this->managemen();

        switch ($messageType) {
            case 'login':
                $message .= $this->selamat();
                $message .= $this->nama_member($data->nama_member);
                $message .= $this->id_member($data->id_member);
                $message .= $this->password($data->pass_member);
                $message .= $this->pin($data->pin_member);
                $message .= $this->wa($data->hp_member);
                $message .= $this->terima_kasih();
                break;
            case 'pendaftaran':
                $message .= $this->selamat();
                $message .= $this->nama_member($data->nama_member);
                $message .= $this->id_member($data->id_member);
                $message .= $this->password($data->pass_member);
                $message .= $this->pin($data->pin_member);
                $message .= $this->wa($data->hp_member);
                $message .= "Anda telah terdaftar di website *_" . SITE_HOST . "_*\n";
                $message .= $this->terima_kasih();
                break;
            case 'pendaftaran_stokis':
                $message .= $this->selamat();
                $message .= $this->nama_stokis($data->nama_stokis);
                $message .= $this->id_stokis($data->id_stokis);
                $message .= $this->password($data->password);
                $message .= $this->pin($data->pin);
                $message .= $this->wa($data->no_handphone);
                $message .= "Anda telah terdaftar di website *_" . SITE_HOST . "_*\n";
                $message .= $this->terima_kasih();
                break;
            case 'bonus':
                $message .= $this->selamat();
                $message .= $this->nama_member($data->nama_member);
                $message .= $this->id_member($data->id_member);
                $message .= "Mendapatkan bonus *" . $data['jenis_bonus'] . "* Sebesar *" . currency($data['nominal_bonus']) . "* " . $data['keterangan'] . " di _BISNIS " . SITE_HOST . "_ \n";
                $message .= $this->terima_kasih();
                break;
            case 'transfer':
                $message .= $this->selamat();
                $message .= $this->nama_member($data->nama_member);
                $message .= $this->id_member($data->id_member);
                $message .= "*" . $data['keterangan'] . "* sebesar *" . rp($data['total_transfer']) . "* telah kami transfer ke rekening ";
                $message .= "*" . $data['nama_bank'] . "* *(" . $data['atas_nama_rekening'] . ")* *" . $data['no_rekening'] . "*\n";
                $message .= $this->terima_kasih();
                break;
                // Additional cases for other types...
        }
        return $message;
    }

    public function smsKeMember($messageType, $data = [], $no_hp, $tanggal = '')
    {
        $message = $this->formatMessage($messageType, $data, $tanggal);
        $phone = $this->testing ? $this->hp_testing : $no_hp;
        return $this->sendSms($phone, $message);
    }

    public function smsTanpaFormat($message, $no_hp)
    {
        $phone = $this->testing ? $this->hp_testing : $no_hp;
        return $this->sendSms($phone, $message);
    }

    public function smsDataLogin($id_member)
    {
        $data = (new Member())->find($id_member);
        return $this->smsKeMember('login', $data, $data->hp_member);
    }

    public function smsPendaftaran($id_member)
    {
        $data = (new Member())->find($id_member);
        return $this->smsKeMember('pendaftaran', $data, $data->hp_member);
    }

    public function smsPendaftaranStokis($id_stokis)
    {
        $data = (new StokisMember())->find($id_stokis);
        return $this->smsKeMember('pendaftaran_stokis', $data, $data->no_handphone);
    }

    public function smsDepositStokis($stokis_id, $id_deposit, $total_bayar, $tanggal)
    {
        $data = (new StokisMember())->find($stokis_id); // Ganti jika perlu
        $depositDetails = (new StokisDepositDetail())->index($id_deposit);

        $message = $this->pesan_otomatis();
        $message .= $this->hariini($tanggal);
        $message .= $this->id_stokis($data->id_stokis);
        $message .= $this->nama_stokis($data->nama_stokis);
        $message .= "Anda telah melakukan Deposit Order sebesar *".rp($total_bayar). "*\n";
        $message .= "Detail Produk:\n";

        $no = 0;
        foreach ($depositDetails as $detail) {
            $no++;
            $message .= $no.". *".$detail->name." - " . $detail->nama_produk . " ".$detail->qty." ".$detail->satuan."* : ";
            $message .= "  ".rp($detail->harga)." x ".currency($detail->qty). " = ". rp($detail->jumlah) . "\n"; // Pastikan nama field sesuai
        }
        $message .= $this->terima_kasih();

        return $this->smsTanpaFormat($message, $data->no_handphone);
    }

    public function smsBonus($id_member, $jenis_bonus, $nominal_bonus, $keterangan, $tanggal)
    {
        $member = (new Member())->find($id_member);
        $data = [
            'id_member' => $member->id_member,
            'nama_member' => $member->nama_member,
            'jenis_bonus' => $jenis_bonus,
            'nominal_bonus' => $nominal_bonus,
            'keterangan' => $keterangan
        ];
        return $this->smsKeMember('bonus', $data, $member->hp_member, $tanggal);
    }

    public function smsTransferBonus($id_member, $keterangan, $total_transfer, $tanggal)
    {
        $member = (new Member())->detail($id_member);
        $data = [
            'keterangan' => $keterangan,
            'total_transfer' => $total_transfer,
            'nama_bank' => $member->nama_bank,
            'atas_nama_rekening' => $member->atas_nama_rekening,
            'no_rekening' => $member->no_rekening
        ];
        return $this->smsKeMember($id_member, 'transfer', $data, $tanggal);
    }

    public function smsRewardPoin($id_member, $keterangan, $total_transfer, $tanggal)
    {
        $data = [
            'keterangan' => $keterangan,
            'total_transfer' => $total_transfer
        ];
        return $this->smsKeMember($id_member, 'reward', $data, $tanggal);
    }

    public function smsTransferPoin($id_member, $jenis_penarikan, $keterangan, $total_transfer, $tanggal)
    {
        $member = (new Member())->detail($id_member);
        if ($jenis_penarikan == 'coin') {
            $address = "*Alexa Coin* : *" . $member->address_coin . "*\n";
        } else {
            $address = "*Akun Marketplace* : *" . $member->username_marketplace . "*\n";
            $total_transfer = currency($total_transfer);
        }
        $data = [
            'keterangan' => $keterangan,
            'total_transfer' => $total_transfer,
            'address' => $address
        ];
        return $this->smsKeMember($id_member, 'transfer', $data, $tanggal);
    }

    public function smsBonusNew($id_member, $nominal_bonus, $keterangan, $tanggal)
    {
        $data = [
            'nominal_bonus' => $nominal_bonus,
            'keterangan' => $keterangan
        ];
        return $this->smsKeMember($id_member, 'bonus', $data, $tanggal);
    }

    public function smsOrderProses($id_member, $total_harga, $total_pin, $tanggal)
    {
        $message = $this->pesan_otomatis();
        $message .= $this->hariini($tanggal);
        $message .= "Belanja Produk anda berhasil diproses sebesar *Rp" . currency($total_harga) . "*\n";
        $message .= $this->terima_kasih();
        return $this->sendSms($this->testing ? $this->hp_testing : (new Member())->detail($id_member)->hp_member, $message);
    }

    public function smsTransferReward($id_member, $reward, $tanggal)
    {
        $message = $this->formatMessage($id_member, 'transfer', ['reward' => $reward], $tanggal);
        return $this->sendSms($this->testing ? $this->hp_testing : (new Member())->detail($id_member)->hp_member, $message);
    }

    public function smsCancelReward($id_member, $reward, $tanggal)
    {
        $message = $this->formatMessage($id_member, 'cancel', ['reward' => $reward], $tanggal);
        return $this->sendSms($this->testing ? $this->hp_testing : (new Member())->detail($id_member)->hp_member, $message);
    }

    private function pesan_otomatis()
    {
		return "Pesan Otomatis dari _*".SITENAME."*_\n\n";
    }

    private function hariini($today){
		if ($today == '') {
			return '';
		}
		return "Pada Hari ini : *".tgl_indo_hari($today)."*\nPukul : *".jam($today)."*\n\n";
    }

	private function managemen(){
		return "Segenap Managemen *_".SITE_PT."_* ";
	}

	private function selamat(){
	  return "mengucapkan *_Selamat!_* kepada: \n\n";
	}
	private function nama_member($nama_member){
		if ($nama_member == '') {
			return '';
		}
		return "Nama : *".$nama_member."*\n";
	}
  
    
	private function password($password){
		if ($password == '') {
			return '';
		}
		return "Password Login : *".base64_decode($password)."*\n";
	}
    
	private function pin($pin){
		if ($pin == '') {
			return '';
		}
		return "PIN : *".base64_decode($pin)."*\n";
	}
    
	private function username($username){
		if ($username == '') {
			return '';
		}
		return "Username : *".$username."*\n";
	}
    
	private function id_member($id_member){
		if ($id_member == '') {
			return '';
		}
		return "No Id : *".$id_member."*\n";
	}
    
	private function wa($wa){
		if ($wa == '') {
			return '';
		}
		return "No WA : *".$wa."*\n";
	}

    private function terima_kasih()
    {
		return "\n*Terima Kasih*\n_".SITE_HOST."_";
    }
    
	private function id_stokis($id_stokis){
		return "ID Stokis : *".$id_stokis."*\n";
	}
    
	private function nama_stokis($nama_stokis){
		return "Nama Stokis : *".$nama_stokis."*\n\n";
	}
}
