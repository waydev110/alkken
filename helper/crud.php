<?php
function setData($arr_field, $dir_img)
{
    $data = [];
    foreach ($arr_field as $index => $field) {
        $subdata = [];
        switch ($field['type']) {
            case 'varchar':
                $value = addslashes(strip_tags($_POST[$field['column']]));
                break;
            case 'text':
                $value = $_POST[$field['column']];
                break;
            case 'password':
                $value = base64_encode($_POST[$field['column']]);
                break;
            case 'number':
                $value = number($_POST[$field['column']]);
                break;
            case 'date':
                if ($field['input'] == '') {
                    $value = null;
                } else {
                    $value = date('Y-m-d', strtotime($_POST[$field['column']]));
                }
                break;
            case 'datetime':
                if ($field['input'] == '') {
                    $value = date('Y-m-d H:i:s');
                } else {
                    $value = date('Y-m-d H:i:s', strtotime($_POST[$field['column']]));
                }
                break;
            case 'slug':
                $from_column = $field['from_column'];
                $input = addslashes(strip_tags($_POST[$from_column]));
                $value = slug($input);
                break;
            case 'image':
                $file = $_FILES[$field['column']];
                $value = null;

                if ($file['size'] <> 0) {
                    $input = '';
                    if ($input != '') {
                        $from_column = $field['from_column'];
                        $input = addslashes(strip_tags($_POST[$from_column]));
                    }
                    $slug = slug($input) . rand(10, 99);
                    $value = storeImage($file, $slug, $dir_img);
                }
                break;

            default:
                $value = null;
                break;
        }
        if ($value != null) {
            $subdata['column'] = $field['column'];
            $subdata['value'] = $value;
            $data[] = $subdata;
        }
    }
    return $data;
}

function generateAddForm($arr_field, $url, $dir_img, $data = null)
{
    $html = '<form id="formSubmit" class="form-horizontal" enctype="multipart/form-data" action="controller/' . $url . '/create.php" method="post" data-redirect-url = "' . site_url($url) . '">
                <div class="box-body">';
    foreach ($arr_field as $index => $field) {
        if ($field['input'] != '' && $field['column'] != '') {
            $column = $field['column'];
            $value = isset($data->$column) ? $data->$column : '';
            $html .= '<div class="form-group">
                        <label for="' . $field['column'] . '" class="col-sm-2 control-label">' . $field['label'] . '</label>
                        <div class="col-sm-10">';
            switch ($field['input']) {
                case 'multi_image':
                    $html .= '
                            <div class="preview-container" id="preview-container">
                                <div class="upload-area" id="upload-area">
                                    <i class="fal fa-plus-circle fa-4x"></i>
                                    <p class="mt-2">Tambah Gambar</p>
                                    <input type="file" id="' . $field['column'] . '" name="' . $field['column'] . '[]" multiple accept="image/*" style="display: none;">
                                    <input type="hidden" name="image_order" id="image_order">
                                </div>
                            </div>';
                    break;
                case 'file':
                    $html .= '<input type="file" class="form-control" name="' . $field['column'] . '" id="' . $field['column'] . '">';
                    break;
                case 'select':
                    $html .= '<select class="form-control select2" id="' . $field['column'] . '" name="' . $field['column'] . '">
                                                <option value="">' . $field['placeholder'] . '</option>';
                    foreach ($field['option'] as $key => $option) {
                        $selected =  isset($data->$column) ? ($option['value'] == $data->$column ? 'selected' : '') : '';
                        $html .= '<option value="' . $option['value'] . '" ' . $selected . '>' . $option['label'] . '</option>';
                    }
                    $html .= '</select>';
                    break;
                case 'checkbox':
                    foreach ($field['option'] as $key => $option) {
                        $checked =  $option['data'] == $option['id'] ? 'checked' : '';
                        $html .= '<div class="col-sm-2">';
                        $html .= '<input type="checkbox" name="' . $field['column'] . '[]" id="' . $option['value'] . $key . '" value="' . $option['value'] . '" ' . $checked . '>';
                        $html .= ' <label for="' . $option['value'] . $key . '" class="control-label">' . $option['label'] . '</label>';
                        $html .= '</div>';
                    }
                    break;
                case 'currency':
                    $html .= '<div class="input-group">
                                                    <span class="input-group-addon">Rp.</span>
                                                    <input type="text" class="form-control autonumeric3" name="' . $field['column'] . '" id="' . $field['column'] . '" placeholder="' . $field['placeholder'] . '" value="' . $value . '">
                                                </div>';
                    break;
                case 'decimal':
                    $html .= '<input type="text" class="form-control autonumeric4" name="' . $field['column'] . '" id="' . $field['column'] . '" placeholder="' . $field['placeholder'] . '" value="' . $value . '">';
                    break;
                case 'int':
                    $html .= '<input type="number" class="form-control" name="' . $field['column'] . '" id="' . $field['column'] . '" placeholder="' . $field['placeholder'] . '" value="' . $value . '">';
                    break;
                case 'text':
                    $html .= '<input type="text" class="form-control" name="' . $field['column'] . '" id="' . $field['column'] . '" placeholder="' . $field['placeholder'] . '" value="' . $value . '">';
                    break;
                case 'password':
                    $html .= '<input type="password" class="form-control" name="' . $field['column'] . '" id="' . $field['column'] . '" placeholder="' . $field['placeholder'] . '" value="' . $value . '">';
                    break;
                case 'date':
                    $html .= '<input type="date" class="form-control" name="' . $field['column'] . '" id="' . $field['column'] . '" placeholder="' . $field['placeholder'] . '" value="' . $value . '">';
                    break;
                case 'textarea':
                    $html .= '<textarea class="form-control ckeditor" id="' . $field['column'] . '" name="' . $field['column'] . '" placeholder="' . $field['placeholder'] . '">' . $value . '</textarea>';
                    break;
            }
            $html .= '</div>
                        </div>';
        }
    }
    $html .= '<div class="bottom">
                    <a href="?go=' . $url . '" class="btn btn-default"> <i class="fa fa-arrow-left"></i>Batal</a>
                    <button type="button" class="btn btn-primary pull-right" id="btnSubmit">Simpan</button>
                </div>
            </div>
        </form>';
    return $html;
}


function generateEditForm($arr_field, $url, $dir_img, $data)
{
    $html = '<form id="formSubmit" class="form-horizontal" enctype="multipart/form-data" action="controller/' . $url . '/edit.php" method="post" data-redirect-url = "' . site_url($url) . '">
                <input type="hidden" name="id" value="' . $data->id . '">
                <div class="box-body">';
    foreach ($arr_field as $index => $field) {
        if ($field['input'] != '') {
            $column = $field['column'];
            $html .= '<div class="form-group">
                        <label for="' . $column . '" class="col-sm-2 control-label">' . $field['label'] . '</label>
                        <div class="col-sm-10">';
            switch ($field['input']) {
                case 'multi_image':
                    $html .= '
                                                <div class="preview-container" id="preview-container">';
                    $image_order = [];
                    foreach ($field['option'] as $key => $option) {
                        $html .= '<div class="image-box" data-index="' . $key . '">
                                                                    <img src="' . $option['label'] . '">
                                                                    <button type="button" class="btn btn-sm btn-block btn-danger remove-btn mt-2" onclick="removeImage(' . "'" . $option['value'] . "'" . ', this)">
                                                                    <i class="fa fa-times"></i> Hapus</button>
                                                                    <input type="hidden" name="images[]" value="' . $option['value'] . '">
                                                                </div>';
                        $image_order[] = $option['sorting'];
                    }
                    $html .= '      <div class="upload-area" id="upload-area">
                                                        <i class="fal fa-plus-circle fa-4x"></i>
                                                        <p class="mt-2">Tambah Gambar</p>
                                                        <input type="file" id="' . $field['column'] . '" name="' . $field['column'] . '[]" multiple accept="image/*" style="display: none;">
                                                        <input type="hidden" name="image_order" id="image_order" value="' . implode(',', $image_order) . '">
                                                    </div>
                                                </div>';
                    break;
                case 'previous_image':
                    $from_column = $field['from_column'];
                    $html .= '<img src="../images/' . $dir_img . '/' . $data->$from_column . '" width="280">';
                    break;
                case 'file':
                    $html .= '<input type="file" class="form-control" name="' . $column . '" id="' . $column . '">';
                    break;
                case 'select':
                    $html .= '<select class="form-control select2" id="' . $column . '" name="' . $column . '">
                                                <option value="">' . $field['placeholder'] . '</option>';
                    foreach ($field['option'] as $key => $option) {
                        $selected =  $option['value'] == $data->$column ? 'selected' : '';
                        $html .= '<option value="' . $option['value'] . '" ' . $selected . '>' . $option['label'] . '</option>';
                    }
                    $html .= '</select>';
                    break;
                case 'checkbox':
                    foreach ($field['option'] as $key => $option) {
                        $checked =  $option['data'] == $option['id'] ? 'checked' : '';
                        $html .= '<div class="col-sm-2">';
                        $html .= '<input type="checkbox" name="' . $field['column'] . '[]" id="' . $option['value'] . $key . '" value="' . $option['value'] . '" ' . $checked . '>';
                        $html .= ' <label for="' . $option['value'] . $key . '" class="control-label">' . $option['label'] . '</label>';
                        $html .= '</div>';
                    }
                    break;
                case 'currency':
                    $html .= '<div class="input-group">
                                                    <span class="input-group-addon">Rp.</span>
                                                    <input type="text" class="form-control autonumeric3" name="' . $field['column'] . '" id="' . $field['column'] . '" placeholder="' . $field['placeholder'] . '" value="' . $data->$column . '">
                                                </div>';
                    break;
                case 'decimal':
                    $html .= '<input type="text" class="form-control autonumeric4" name="' . $field['column'] . '" id="' . $field['column'] . '" placeholder="' . $field['placeholder'] . '" value="' . $data->$column . '">';
                    break;
                case 'int':
                    $html .= '<input type="number" class="form-control" name="' . $field['column'] . '" id="' . $field['column'] . '" placeholder="' . $field['placeholder'] . '" value="' . $data->$column . '">';
                    break;
                case 'text':
                    $html .= '<input type="text" class="form-control" name="' . $column . '" id="' . $column . '" placeholder="' . $field['placeholder'] . '" value="' . $data->$column . '">';
                    break;
                case 'password':
                    $html .= '<input type="password" class="form-control" name="' . $field['column'] . '" id="' . $field['column'] . '" placeholder="' . $field['placeholder'] . '" value="' . base64_decode($data->$column) . '">';
                    break;
                case 'date':
                    $html .= '<input type="date" class="form-control" name="' . $field['column'] . '" id="' . $field['column'] . '" placeholder="' . $field['placeholder'] . '" value="' . $data->$column . '">';
                    break;
                case 'textarea':
                    $html .= '<textarea class="form-control ckeditor" id="' . $field['column'] . '" name="' . $field['column'] . '">' . $data->$column . '</textarea>';
                    break;
            }
            $html .= '</div>
                        </div>';
        }
    }
    $html .= '<div class="bottom">
                    <a href="?go=' . $url . '" class="btn btn-default"> <i class="fa fa-arrow-left"></i>Batal</a>
                    <button type="button" class="btn btn-primary pull-right" id="btnSubmit">Update</button>
                </div>
            </div>
        </form>';
    return $html;
}
