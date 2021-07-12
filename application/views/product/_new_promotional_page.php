<?php
error_reporting(0);
$sess_lang = $this->selected_lang->id;
if($newinfo){
    $newinfo = (array)$newinfo;
} else{
    $newinfo = array();
}
?>
<div class="modal fade" id="updateNewLandingPage" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="updateNewLandingPage" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Manage Promotional Page in <?php echo $this->selected_lang->name; ?></h5>
        <?php //print_r($this->selected_lang); ?>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <?php echo form_open_multipart('product_controller/edit_new_promotional_page_post'); ?>
        <input type="hidden" name="lang_id" value="<?php echo $sess_lang; ?>" />
        <div class="modal-body">
            <input type="hidden" name="id" value="<?php echo $product->id; ?>">
            
            <!-- <div class="form-box">
                <div class="form-box-body">    
                    <div class="row">
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label"> Language : </label>
                                
                                <select name="lang_id_2" class="form-control form-input not_in_use_ only for showing" required disabled="disabled" >
                                    <?php foreach ($this->languages as $language): ?>
                                        <option <?php if($language->id == $sess_lang) echo "selected"; ?> value="<?php echo $language->id; ?>"><?php echo $language->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div> -->
            
            
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 1</h4>
                </div>
                <div class="form-box-body">    
                    <div class="row">
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label"> Title</label>
                                <input type="text" name="s1_heading" class="form-control form-input" value="<?php echo html_escape($newinfo['s1_heading']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label"> Device Name </label>
                                <input type="text" name="s1_device_name" class="form-control form-input" value="<?php echo html_escape($newinfo['s1_device_name']); ?>"  required>
                            </div>
                        </div>
                        
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Background Image (1920X9272px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                        <input type="file" name="image_background" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info1').html($(this).val());">
                                    </a>
                                    (.png, .jpg, .jpeg)
                                </div>
                                <span class='label label-info' id="upload-file-info1"></span>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Brand Image (80X30px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                        <input type="file" name="image_brand" accept=".png" onchange="$('#upload-file-info2').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info2"></span>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Product Image (80X30px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                        <input type="file" name="s1_product_image" accept=".png" onchange="$('#upload-file-info3').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info3"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 2</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label">Title</label>
                                <input type="text" name="s2_heading" class="form-control form-input" value="<?php echo html_escape($newinfo['s2_heading']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label">Image (959X323px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                        <input type="file" name="s2_image" accept=".png" onchange="$('#upload-file-info4').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info4"></span>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 3</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Number 1</label>
                                <input type="text" name="s3_sub_number_1" class="form-control form-input" value="<?php echo html_escape($newinfo['s3_sub_number_1']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Details 1</label>
                                <input type="text" name="s3_sub_text_1" class="form-control form-input" value="<?php echo html_escape($newinfo['s3_sub_text_1']); ?>" required>
                            </div>
                            
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Number 2</label>
                                <input type="text" name="s3_sub_number_2" class="form-control form-input" value="<?php echo html_escape($newinfo['s3_sub_number_2']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Details 2</label>
                                <input type="text" name="s3_sub_text_2" class="form-control form-input" value="<?php echo html_escape($newinfo['s3_sub_text_2']); ?>" required>
                            </div>
                            
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Number 3</label>
                                <input type="text" name="s3_sub_number_3" class="form-control form-input" value="<?php echo html_escape($newinfo['s3_sub_number_3']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label"> Details 3</label>
                                <input type="text" name="s3_sub_text_3" class="form-control form-input" value="<?php echo html_escape($newinfo['s3_sub_text_3']); ?>" required>
                            </div>
                            
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Image 1 (60X56px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                        <input type="file" name="s3_main_image_1" accept=".png" onchange="$('#upload-file-info5').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info5"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Image 1 Details</label>
                                <input type="text" name="s3_main_text_1" class="form-control form-input" value="<?php echo html_escape($newinfo['s3_main_text_1']); ?>" required>
                            </div>
                            
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Image 2 (60X56px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                        <input type="file" name="s3_main_image_2" accept=".png" onchange="$('#upload-file-info6').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info6"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Image 2 Details</label>
                                <input type="text" name="s3_main_text_2" class="form-control form-input" value="<?php echo html_escape($newinfo['s3_main_text_2']); ?>" required>
                            </div>
                            
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Image 3 (60X56px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                        <input type="file" name="s3_main_image_3" accept=".png" onchange="$('#upload-file-info7').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info7"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Image 3 Details</label>
                                <input type="text" name="s3_main_text_3" class="form-control form-input" value="<?php echo html_escape($newinfo['s3_main_text_3']); ?>" required>
                            </div>
                            
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Image 4 (60X56px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                            <input type="file" name="s3_main_image_4" accept=".png" onchange="$('#upload-file-info8').html($(this).val());">
                                    </a>
                                        (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info8"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Image 4 Details</label>
                                <input type="text" name="s3_main_text_4" class="form-control form-input" value="<?php echo html_escape($newinfo['s3_main_text_4']); ?>" required>
                            </div>
                            
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Image 5 (60X56px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                        <input type="file" name="s3_main_image_5" accept=".png" onchange="$('#upload-file-info9').html($(this).val());">
                                        </a>
                                        (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info9"></span>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label">Image 5 Details</label>
                                <input type="text" name="s3_main_text_5" class="form-control form-input" value="<?php echo html_escape($newinfo['s3_main_text_5']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label"> Video URL</label>
                                <input type="url" name="s3_video_url" class="form-control form-input" value="<?php echo html_escape($newinfo['s3_video_url']); ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 4</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label">Title</label>
                                <input type="text" name="s4_heading" class="form-control form-input" value="<?php echo html_escape($newinfo['s4_heading']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label">Image (975X360px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                        <input type="file" name="s4_image" accept=".png" onchange="$('#upload-file-info10').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info10"></span>
                            </div>
                        </div>
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <textarea name="s4_details" class="text-editor" id="new_s4_details"><?php echo $newinfo['s4_details']; ?></textarea>
                                <script>CKEDITOR.replace( 'new_s4_details',{width : "100%",height : "200px",}).setData();</script>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 5/6 (Reviews)</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Title</label>
                                <input type="text" name="s5_heading" class="form-control form-input" value="<?php echo html_escape($newinfo['s5_heading']); ?>" required>
                            </div>
                            
                        </div>
                        <div class="col col-md-4">                    
                            <div class="form-group">
                                <label class="control-label">Section Top Banner Image (884X293px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                        <input type="file" name="s5_image" accept=".png" onchange="$('#upload-file-info11').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info11"></span>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Section Bottom Banner Image (710X480px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                        <input type="file" name="s6_review_image" accept=".png" onchange="$('#upload-file-info15').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info15"></span>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Review 1 Image (300X300px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                        <input type="file" name="s6_review_image_1" accept=".png" onchange="$('#upload-file-info12').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info12"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 1  Name</label>
                                <input type="text" name="s6_review_name_1" class="form-control form-input" value="<?php echo html_escape($newinfo['s6_review_name_1']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 1  Age, City</label>
                                <input type="text" name="s6_review_location_1" class="form-control form-input" value="<?php echo html_escape($newinfo['s6_review_location_1']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 1  Comment</label>
                                <input type="text" name="s6_review_comment_1" class="form-control form-input" value="<?php echo html_escape($newinfo['s6_review_comment_1']); ?>" required>
                            </div>
                            
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Review 2 Image (300X300px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                        <input type="file" name="s6_review_image_2" accept=".png" onchange="$('#upload-file-info13').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info13"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 2  Name</label>
                                <input type="text" name="s6_review_name_2" class="form-control form-input" value="<?php echo html_escape($newinfo['s6_review_name_2']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 2  Age, City</label>
                                <input type="text" name="s6_review_location_2" class="form-control form-input" value="<?php echo html_escape($newinfo['s6_review_location_2']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 2  Comment</label>
                                <input type="text" name="s6_review_comment_2" class="form-control form-input" value="<?php echo html_escape($newinfo['s6_review_comment_2']); ?>" required>
                            </div>
                            
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Review 3 Image (300X300px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                        <input type="file" name="s6_review_image_3" accept=".png" onchange="$('#upload-file-info14').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info14"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 3  Name</label>
                                <input type="text" name="s6_review_name_3" class="form-control form-input" value="<?php echo html_escape($newinfo['s6_review_name_3']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 3  Age, City</label>
                                <input type="text" name="s6_review_location_3" class="form-control form-input" value="<?php echo html_escape($newinfo['s6_review_location_3']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 3  Comment</label>
                                <input type="text" name="s6_review_comment_3" class="form-control form-input" value="<?php echo html_escape($newinfo['s6_review_comment_3']); ?>" required>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 7 (Suggested Product)</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-2">
                            <div class="form-group">
                                <label class="control-label">Product ID </label>
                                <input type="text" name="s11_cross_sale_id" class="form-control form-input" value="<?php echo html_escape($newinfo['s11_cross_sale_id']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-5">
                            <div class="form-group">
                                <label class="control-label">Product Name </label>
                                <input type="text" name="s7_heading" class="form-control form-input" value="<?php echo html_escape($newinfo['s7_heading']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="col col-md-5">
                            <div class="form-group">
                                <label class="control-label">Image (430X410px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                        <input type="file" name="s7_image" accept=".png" onchange="$('#upload-file-info16').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info16"></span>
                            </div>
                        </div>
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label">Suggested Product Description</label>
                                <textarea name="s7_details" class="text-editor" id="new_s7_details"><?php echo $newinfo['s7_details']; ?></textarea>
                                <script>CKEDITOR.replace( 'new_s7_details',{width : "100%",height : "200px",}).setData();</script>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="form-box form-box-body">
                <div class="row">
                    <div class="col col-md-12">
                        <div class="form-group">
                            <label class="control-label">Section 8 Title</label>
                            <input type="text" name="s8_heading" class="form-control form-input" value="<?php echo html_escape($newinfo['s8_heading']); ?>" required>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 9</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label">Avg Cost Description</label>
                                <input type="text" name="s9_details" class="form-control form-input" value="<?php echo html_escape($newinfo['s9_details']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label">Title</label>
                                <input type="text" name="s9_heading" class="form-control form-input" value="<?php echo html_escape($newinfo['s9_heading']); ?>" required>
                            </div>
                        </div> 
                        
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label">Image (500X695px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                        <input type="file" name="s9_image" accept=".png" onchange="$('#upload-file-info17').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info17"></span>
                            </div>
                        </div>
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <textarea name="s9_description" class="text-editor" id="new_s9_description"><?php echo $newinfo['s9_description']; ?></textarea>
                                <script>CKEDITOR.replace( 'new_s9_description',{width : "100%",height : "200px",}).setData();</script>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 10 (Guarantee)</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Guarantee Title</label>
                                <input type="text" name="s10_description" class="form-control form-input" value="<?php echo html_escape($newinfo['s10_description']); ?>" required>
                            </div>
                            
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Guarantee Point 1</label>
                                <input type="text" name="s10_point_1" class="form-control form-input" value="<?php echo html_escape($newinfo['s10_point_1']); ?>" required>
                            </div>
                            
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Guarantee Point 2</label>
                                <input type="text" name="s10_point_2" class="form-control form-input" value="<?php echo html_escape($newinfo['s10_point_2']); ?>" required>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 11 (Buy Now)</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label"> Main Product Title</label>
                                <input type="text" name="s11_product_title" class="form-control form-input" value="<?php echo html_escape($newinfo['s11_product_title']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label">Suggested Product Image (300X136px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        Select Image
                                        <input type="file" name="s11_cross_sale_image" accept=".png" onchange="$('#upload-file-info18').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info18"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Terms & Conditions</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label">Link Title</label>
                                <input type="text" name="terms_condition_heading" class="form-control form-input" value="<?php echo html_escape($newinfo['terms_condition_heading']); ?>" required>
                            </div>
                            
                        </div>
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <textarea name="terms_conditions" class="text-editor" id="new_s9_description"><?php echo $newinfo['terms_conditions']; ?></textarea>
                                <script>CKEDITOR.replace( 'new_s9_description',{width : "100%",height : "200px",}).setData();</script>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Frequently Asked Questions (FAQ)</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label">Link Title</label>
                                <input type="text" name="faq_heading" class="form-control form-input" value="<?php echo html_escape($newinfo['faq_heading']); ?>">
                            </div>
                            
                        </div>
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <textarea name="faq_details" class="text-editor" id="new_faq_details"><?php echo $newinfo['faq_details']; ?></textarea>
                                <script>CKEDITOR.replace( 'new_faq_details',{width : "100%",height : "200px",}).setData();</script>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-custom" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary text-white">Submit</button>
        </div>
        <?php echo form_close(); ?>
    </div>
  </div>
</div>