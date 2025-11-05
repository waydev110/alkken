<?php 
    function titik($id, $upline, $action, $next = '0'){

        $cp = new classMemberPeringkat();
        $cm = new classMember();
        if($id == null){
            $member = null;
        } else {
            $member = $cm->genealogy($id);
            $member = $cm->detail($member->id);
        }
        

        if ($member == null) {
            global $node;
            $node[$next][1] = null;
            $node[$next][2] = null;
        
            if($action == false) {
                $link = '<span class="p-1 text-danger"><i class="fa fa-times-circle fa-6x"></i></span>';
                $bg = 'bg-danger';
            } else {
                $link = '<a href="?go=member_create&upline='.base64_encode($upline).'" class="p-1 text-success"><i class="fa fa-plus-circle fa-6x"></i></a>';
                $bg = 'bg-success';
            }


            global $upline;
            $upline[$next][1] = null;
            $upline[$next][2] = null;

            global $action;
            $action[$next][1] = false;
            $action[$next][2] = false;
?>
            <div class="card-member member-blank">
                <div class="card-member-header">
    				<h2 class="<?=$bg?>">?</h2>
                    <?=$link?>
                </div>
                <div class="card-member-body">
                    <div class="member-profile">
                        <h3>?</h3>
                        <h5>-</h5>
                        <!-- <h3 class="member-packet">-</h3> -->
                        <h5>-</h5>
                    </div>
                    <div class="member-info">
                        <span>0</span>
                        <span><i class="fas fa-users"></i></span>
                        <span>0</span>
                    </div>
                    <div class="member-info">
                        <span>0</span>
                        <span><i class="fas fa-people-arrows"></i></span>
                        <span>0</span>
                    </div>
                    <div class="member-info">
                        <span>0</span>
                        <span><i class="fas fa-gift"></i></span>
                        <span>0</span>
                    </div>
                    <div class="member-info">
                        <span>0</span>
                        <span><i class="fas fa-repeat"></i></span>
                        <span>0</span>
                    </div>
                    <div class="member-profile">
                        <h3 class="member-rank"></h3>
                    </div>
                </div>
            </div>
<?php            
        } else {

            global $node;
            $node[$next][1] = $member->kaki_kiri == '' ? null:$member->kaki_kiri;
            $node[$next][2] = $member->kaki_kanan == '' ? null:$member->kaki_kanan;
            
            global $upline;
            $upline[$next][1] = $member->id;
            $upline[$next][2] = $member->id;

            global $action;
            $action[$next][1] = true;
            $action[$next][2] = $member->kaki_kiri == '' ? false:true;
            // $class_peringkat = 'premium';
            // $member->icon = 'icon_'.$class_peringkat.'.png';
            $nama_samaran = $member->nama_samaran == '' ? 'Undefined' : strtoupper($member->nama_samaran);
            $user_member = $member->user_member == '' ? 'Undefined' : strtoupper($member->user_member);

            // $peringkat_member = $cm->peringkat($member->peringkat);
            // $peringkat = $peringkat_member == '' ? 'MEMBER' : strtoupper($peringkat_member);
            // $total_pasangan_rekap = $cm->get_total_pasangan_rekap($id);
            // $total_flash_in = $cm->get_total_flush_out($id);
            $total_pasangan_rekap = 0;
            $total_flash_in = 0;
?>

            <div class="card-member">
                <div class="card-member-header">
                    <h2 class="bg-theme text-white"><strong>QUALIFIED</strong></h2>
                </div>
                <!-- <a href="?go=genealogy&id_member=<?=$member->id_member?>"><img src="../images/peringkat/<?=$member->gambar?>" alt="" width="100%"></a>			 -->
    			<div class="card-member-body">
    				<div class="member-profile">
    					<h3><?=$member->id_member?></h3>
    					<h3><?=$nama_samaran?></h3>
                        <!-- <h3 class="size-12 member-packet bg-primary text-white" style="font-weight:bold"><?=strtoupper($nama_peringkat)?></h3>     -->
    					<h5 data-toggle="tooltip" data-placement="top" title="Tanggal Gabung"><?=tgl_indo($member->created_at)?></h5>
    				</div>
    				<div class="member-info">
    					<span><?=currency($member->jumlah_kiri)?></span>
    					<span data-toggle="tooltip" data-placement="top" title="Jumlah Member"><i class="fas fa-users"></i></span>
    					<span><?=currency($member->jumlah_kanan)?></span>
    				</div>
    				<!-- <div class="member-info">
    					<span><?=$member->potensi_kiri?></span>
    					<span data-toggle="tooltip" data-placement="top" title="Poin Pasangan"><i class="fas fa-people-arrows"></i></span>
    					<span><?=$member->potensi_kanan?></span>
    				</div> -->
    				<!-- <div class="member-info">
    					<span><?=$member->reward_kiri?></span>
    					<span data-toggle="tooltip" data-placement="top" title="Poin Reward"><i class="fas fa-gift"></i></span>
    					<span><?=$member->reward_kanan?></span>
    				</div> -->
    				<!-- <div class="member-info">
    					<span><?=$member->promo_kiri?></span>
    					<span data-toggle="tooltip" data-placement="top" title="Poin Reward Promo"><i class="fas fa-gift"></i></span>
    					<span><?=$member->promo_kanan?></span>
    				</div> -->
    				<div class="member-profile">
    					<h3 class="member-rank"></h3>
    				</div>
    			</div>
    		</div>
<?php
        }
    }
?>