<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classPlan.php';
    $mod_url = 'produk';

    $obj = new classPlan();
    
    $id_produk = '';
    if(isset($_POST['id_produk'])){
        $id_produk = addslashes(strip_tags($_POST['id_produk']));
    }

    $plan = $obj->index();
    $html = '';
    while($row = $plan->fetch_object()){
        $checked = $obj->produk_plan($row->id, $id_produk) > 0 ? 'checked="checked"' : ''; 
        $html .= '<div class="col-sm-2">
                    <input type="checkbox" id="produk_plan'.$row->id.'" value="'.$row->id.'" name="produk_plan[]" '.$checked.'>
                    <label for="produk_plan'.$row->id.'" class="control-label">'.$row->nama_plan.'</label>
                 </div>';
    }
    echo json_encode(['status' => true, 'html' => $html]);
    if($plan->num_rows == 0){
        return false;
    }