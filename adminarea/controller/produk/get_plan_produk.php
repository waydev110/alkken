<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classPlan.php';
    $mod_url = 'produk';

    $obj = new classPlan();
    
    $id_produk = '';
    if(isset($_POST['id_produk'])){
        $id_produk = addslashes(strip_tags($_POST['id_produk']));
    }
    if($plan->num_rows == 0){
        echo json_encode(['status' => true, 'html' => '']);
        return false;
    }

    $plan = $obj->index();
    $html = '';
    while($row = $plan->fetch_object()){
        $selected = $obj->produk_plan($row->id, $id_produk) > 0 ? 'selected="selected"' : ''; 
        $html .= '<div class="col-sm-4">
                    <input type="checkbox" name="produk_plan[]" id="produk_plan'.$row->id.'" '.$selected.'>
                    <label for="" class="control-label">'.$row->nama_plan.'</label>
                    </div>';
    }