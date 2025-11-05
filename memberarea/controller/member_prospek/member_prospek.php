<?php 
    session_start();
    include ("../../model/classMemberProspek.php");
    $cm = new classMemberProspek();
    $sponsor = $session_member_id;
    
    $member_prospek = $cm->index($sponsor);
    $html = '';
    while($row = $member_prospek->fetch_object()) {
        $html .= '<option value="'.$row->id.'">'.$row->nama_member.'</option>';
    }
    echo $html;
?>