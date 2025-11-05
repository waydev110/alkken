<?php 
include ("model/classMemberPeringkat.php");
include ("model/function.php");
$cmp = new classMemberPeringkat();
$query = $cmp->index();
?>
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Daftar History Peringkat</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body box-profile">
				<div class="table-responsive">
					<table class="table table-bordered" id="example1">
						<thead>
							<tr>
								<th>No</th>
								<th>ID Member</th>
								<th>Nama Member</th>
								<th>Peringkat Sebelumnya</th>
								<th>Peringkat Upgrade</th>
								<th>Jenis Upgrade</th>
								<th>Tanggal Upgrade</th>
							</tr>
						</thead>
						<tbody>
							<?php 
                        $no=1;
            			while ($data = $query->fetch_object()) {
            				?>
							<tr>
								<td><?=$no;?></td>
								<td class="text-left"><?=$data->id_member?></td>
								<td class="text-left"><?=$data->nama_member?></td>
								<td class="text-left"><?=$data->peringkat_sebelumnya == null ? 'Member' : $data->peringkat_sebelumnya?></td>
								<td class="text-left"><?=$data->peringkat == null ? 'Member' : $data->peringkat?></td>
								<td class="text-left"><?=$data->manual_upgrade == '1' ? 'Manual' : 'Otomatis'?></td>
								<td class="text-left"><?=$data->created_at?></td>
							</tr>
							<?php
                            $no++;
            			}
            			?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>