<?php 
    function titik($member, $action){
        if($member == null){
            if($action == false) {
                $link = '';
                $action_link = '<a href="#"><img src="images/no.png" alt="" width="75"></a>';
                $class = 'member-no';
            } else {
                $link = '<a class="btn btn-sm btn-default" href="?go=member_create&upline='.base64_encode($upline).'" class="p-2">Pasang Baru</a>';
                $class = 'member-add';
                $action_link = '<a href="?go=member_create&upline=<?=base64_encode($upline)?>"><img src="images/add.png" alt="" width="75"></a>';
            }
?>
            <div class="card-member member-blank <?=$class?>">
                <div class="card-member-header">
    				<?=$action_link?>
                </div>
    			<div class="card-member-body">
    				<div class="member-profile">
                        
    					<h3>-</h3>
    				    <h5>-</h5>
    					<h5 data-toggle="tooltip" data-placement="top" title="-">-</h5>
        				<div class="member-info">
        					<span>-</span>
        					<span data-toggle="tooltip" data-placement="top" title="Jumlah Member"><i class="fa-solid fa-circle"></i></span>
        					<span>-</span>
        				</div>
    				</div>
                </div>
    			<div class="card-member-footer">
    			</div>
            </div>
<?php            
        } else {
?>
            <div class="card-member">
    			<div class="card-member-header">
    				<a href="?go=genealogy&id=<?=$member->id_member?>"><img src="images/<?=strtolower($member->nama_paket)?>.png" alt="" width="75"></a>
    			</div>
    			<div class="card-member-body">
    				<div class="member-profile">
    					<h3><?=$member->id_member?></h3>
    				    <h5><?=$member->nama_samaran?></h5>
    					<h5 data-toggle="tooltip" data-placement="top" title="Tanggal Join"><?=date('d/m/Y', strtotime($member->created_at))?></h5>
        				<div class="member-info">
        					<span><?=$member->jumlah_kiri?></span>
        					<span data-toggle="tooltip" data-placement="top" title="Jumlah Member"><i class="fa-solid fa-circle"></i></span>
        					<span><?=$member->jumlah_kanan?></span>
        				</div>
    				</div>
    				<div class="member-toggle">
        				<div class="member-info">
        					<span><?=$member->potensi_kiri?></span>
        					<span data-toggle="tooltip" data-placement="top" title="Potensi Penjualan Grup"><i class="fas fa-people-arrows"></i></span>
        					<span><?=$member->potensi_kanan?></span>
        				</div>
        				<div class="member-info">
        					<span><?=$member->reward_kiri?></span>
        					<span data-toggle="tooltip" data-placement="top" title="Poin Reward"><i class="fas fa-award"></i></span>
        					<span><?=$member->reward_kanan?></span>
        				</div>
    				    
    				</div>
    			</div>
    			<div class="card-member-footer">
    			</div>
    		</div>
<?php
        }
    }
?>