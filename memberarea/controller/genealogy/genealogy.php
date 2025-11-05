<?php 
    require_once '../../../helper/all_member.php';
    include ("../../model/classMember.php");
    $cm = new classMember();
    $genealogy = $cm->genealogy_member($session_member_id);

    $html = '';
    if($genealogy->num_rows > 0){
        $generasi = 0;
        $no = 0;
        while($row = $genealogy->fetch_object()) {
            if($row->kaki_kiri == NULL){
                $link_kiri = '<a href="?go=member_create&upline='.base64_encode($row->id).'" class="text-success"><i class="fa fa-plus"></i></a>';
                $link_kanan = '<span class="text-danger"><i class="fa fa-times"></i></span>';
            } else if($row->kaki_kanan == NULL){
                $link_kiri = $row->kaki_kiri;
                $link_kanan = '<a href="?go=member_create&upline='.base64_encode($row->id).'" class="text-success"><i class="fa fa-plus"></i></a>';
            } else {
                $link_kiri = $row->kaki_kiri;
                $link_kanan = $row->kaki_kanan;
            }
            $generasi = $row->generasi;
            $no++;
            $card_member[$generasi][$no] = '<div class="swiper-slide generasi-child-'.$row->generasi.' upline-'.$row->upline.'" id="'.$row->id.'" data-id="'.$row->id.'" data-upline="'.$row->upline.'" data-posisi="'.$row->posisi.'" data-level="'.$row->generasi.'">
                                                <div class="card-member">
                                                    <div class="card-member-header">
                                                        <h2 class="bg-theme text-white"><strong>'.$row->id.'</strong></h2>
                                                    </div>
                                                    <button class="btn btn-transparent p-0 avatar avatar-80 btn-member">
                                                        <img src="../images/paket/'.$row->gambar.'" alt="" width="100%">
                                                    </button>
                                                    <div class="card-member-body">
                                                        <div class="member-profile">
                                                            <p class="fw-semibold size-12 mb-0" onclick="copyToClipboard(this)">'.$row->id_member.'</p>
                                                            <p class="size-10 text-uppercase">'.$row->nama_samaran.'</p>
                                                        </div>
                                                        <div class="member-info">
                                                            <span class="fw-bolder">'.currency($row->jumlah_kiri).'</span>
                                                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Jumlah '.$lang['member'].'"><i class="fas fa-users"></i></span>
                                                            <span class="fw-bolder">'.currency($row->jumlah_kanan).'</span>
                                                        </div>
                                                        <div class="member-info">
                                                            <span class="fw-bolder">'.currency($row->potensi_kiri).'</span>
                                                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Poin Pasangan"><i class="fas fa-people-arrows"></i></span>
                                                            <span class="fw-bolder">'.currency($row->potensi_kanan).'</span>
                                                        </div>
                                                        <div class="member-info">
                                                            <span class="fw-bolder">'.currency($row->reward_kiri).'</span>
                                                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Poin Reward"><i class="fas fa-award"></i></span>
                                                            <span class="fw-bolder">'.currency($row->reward_kanan).'</span>
                                                        </div>
                                                        <div class="member-profile px-3">
                                                            <a href="'.site_url('posting_ro').'&id_member='.base64_encode($row->id).'" class="btn btn-sm btn-default size-10 rounded-pill">Posting RO</a>
                                                            <div class="row bg-light py-2 text-theme rounded-pill mt-2">
                                                                <div class="col-6">
                                                                    '.$link_kiri.'
                                                                </div>
                                                                <div class="col-6">
                                                                    '.$link_kanan.'
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
        }
        foreach($card_member as $key => $value){
        $html .= '<div class="generasi-container">
            <div class="row mb-3">
                <div class="col">
                    <h6 class="title">Level '.$key.'</h6>
                </div>
                <div class="col-auto">
                    <a href="#" class="small data-text">'.currency(count($value)).' '.$lang['member'].'</a>
                </div>
            </div>    
            <div class="row mb-3">
                <div class="col-12 px-0">
                    <!-- swiper users connections -->
                    <div class="swiper-container connectionwiper" navigation="true">
                        <div class="swiper-wrapper">';
                            foreach($value as $index => $card){
                                $html .= $card;
                            }
                $html .= '</div>
                    </div>
                </div>
            </div>  
        </div>';

        } 
    }
    echo $html;
?>