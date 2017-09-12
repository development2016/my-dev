<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-weight" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_titlepage; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-weight" class="form-horizontal">
        
          <div class="row">
            <div class="col-sm-2">
              <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <li><a href="#tab-geo-zone<?php echo $geo_zone['geo_zone_id']; ?>" data-toggle="tab"><?php echo $geo_zone['name']; ?></a></li>
                <?php } ?>
              </ul>
            </div>
            
            
            <div class="col-sm-10">
              <div class="tab-content">
                <div class="tab-pane active" id="tab-general">
                
                  <div class="form-group">
                      <label class="col-sm-2 control-label">
			          <?php echo $entry_shipdisplay; ?>
			          </label>
                      <div class="col-sm-10">
            	                 <?php if ($b_surereach_geo_weight_shipdisplayoption =='1') { ?>
                                 <?php echo $icon_shipping_1; ?>
                                 <?php } else if ($b_surereach_geo_weight_shipdisplayoption =='2') { ?>
                                 <?php echo $icon_shipping_2; ?>
                                 <?php } else { ?>
                                 <?php echo $icon_shipping_3; ?>
                                 <?php } ?>
					  </div>
                  </div>  
                  
                  <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-b_surereach_geo_weight_shipdisplayoption">
			                 <span data-toggle="tooltip" title="<?php echo $help_shipdisplayoption; ?>"><?php echo $entry_shipdisplayoption; ?></span>
			            </label>
                        <div class="col-sm-10">
                              <select name="b_surereach_geo_weight_shipdisplayoption" id="input-b_surereach_geo_weight_shipdisplayoption" class="form-control">
                              <?php if ($b_surereach_geo_weight_shipdisplayoption =='1') { ?>
                              <option value="1" selected="selected"><?php echo $entry_logo_only; ?></option>
                              <option value="2"><?php echo $entry_text_only; ?></option>
                              <option value="3"><?php echo $entry_logoandtext; ?></option>
                              <?php } else if ($b_surereach_geo_weight_shipdisplayoption =='2') { ?>
                              <option value="1"><?php echo $entry_logo_only; ?></option>
                              <option value="2" selected="selected"><?php echo $entry_text_only; ?></option>
                              <option value="3"><?php echo $entry_logoandtext; ?></option>
                              <?php } else { ?>
                              <option value="1"><?php echo $entry_logo_only; ?></option>
                              <option value="2"><?php echo $entry_text_only; ?></option>
                              <option value="3" selected="selected"><?php echo $entry_logoandtext; ?></option>
                              <?php } ?>
                              </select>
                        </div>
                  </div>
                
                
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-tax-class"><?php echo $entry_tax_class; ?></label>
                    <div class="col-sm-10">
                      <select name="b_surereach_geo_weight_tax_class_id" id="input-tax-class" class="form-control">
                        <option value="0"><?php echo $text_none; ?></option>
                        <?php foreach ($tax_classes as $tax_class) { ?>
                        <?php if ($tax_class['tax_class_id'] == $b_surereach_geo_weight_tax_class_id) { ?>
                        <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                    <div class="col-sm-10">
                      <select name="b_surereach_geo_weight_status" id="input-status" class="form-control">
                        <?php if ($b_surereach_geo_weight_status) { ?>
                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                        <option value="0"><?php echo $text_disabled; ?></option>
                        <?php } else { ?>
                        <option value="1"><?php echo $text_enabled; ?></option>
                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="b_surereach_geo_weight_sort_order" value="<?php echo $b_surereach_geo_weight_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                    </div>
                  </div>
                </div>
                
                
                <?php foreach ($geo_zones as $geo_zone) { ?>
                
                <div class="tab-pane" id="tab-geo-zone<?php echo $geo_zone['geo_zone_id']; ?>">
                
                
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-b_surereach_geo_weight_<?php echo $geo_zone['geo_zone_id']; ?>_min">
					<span data-toggle="tooltip" title="<?php echo $help_min_weight; ?>"><?php echo $entry_min_weight; ?></span>
					</label>
                    <div class="col-sm-10">
                      <input type="text" name="b_surereach_geo_weight_<?php echo $geo_zone['geo_zone_id']; ?>_min" value="<?php echo ${'b_surereach_geo_weight_' . $geo_zone['geo_zone_id'] . '_min'}; ?>" placeholder="<?php echo $entry_min_weight; ?>" id="input-b_surereach_geo_weight_<?php echo $geo_zone['geo_zone_id']; ?>_min" class="form-control" />
                    </div>
                  </div>
                  
                  
                 <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-b_surereach_geo_weight_<?php echo $geo_zone['geo_zone_id']; ?>_max">
					<span data-toggle="tooltip" title="<?php echo $help_max_weight; ?>"><?php echo $entry_max_weight; ?></span>
					</label>
                    <div class="col-sm-10">
                      <input type="text" name="b_surereach_geo_weight_<?php echo $geo_zone['geo_zone_id']; ?>_max" value="<?php echo ${'b_surereach_geo_weight_' . $geo_zone['geo_zone_id'] . '_max'}; ?>" placeholder="<?php echo $entry_max_weight; ?>" id="input-b_surereach_geo_weight_<?php echo $geo_zone['geo_zone_id']; ?>_max" class="form-control" />
                    </div>
                  </div>
                  
                  
                 <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-b_surereach_geo_weight_<?php echo $geo_zone['geo_zone_id']; ?>_hand">
					<span data-toggle="tooltip" title="<?php echo $help_hand; ?>"><?php echo $entry_hand; ?></span>
					</label>
                    <div class="col-sm-10">
                      <input type="text" name="b_surereach_geo_weight_<?php echo $geo_zone['geo_zone_id']; ?>_hand" value="<?php echo ${'b_surereach_geo_weight_' . $geo_zone['geo_zone_id'] . '_hand'}; ?>" placeholder="<?php echo $entry_hand; ?>" id="input-b_surereach_geo_weight_<?php echo $geo_zone['geo_zone_id']; ?>_hand" class="form-control" />
                    </div>
                  </div>
                
                
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-rate<?php echo $geo_zone['geo_zone_id']; ?>">
					<span data-toggle="tooltip" title="<?php echo $help_rate; ?>"><?php echo $entry_rate; ?></span>
					</label>
                    <div class="col-sm-10">
                      <textarea name="b_surereach_geo_weight_<?php echo $geo_zone['geo_zone_id']; ?>_rate" rows="5" placeholder="<?php echo $entry_rate; ?>" id="input-rate<?php echo $geo_zone['geo_zone_id']; ?>" class="form-control"><?php echo ${'b_surereach_geo_weight_' . $geo_zone['geo_zone_id'] . '_rate'}; ?></textarea>
                    </div>
                  </div>
                  
                  
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-status<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $entry_status; ?></label>
                    <div class="col-sm-10">
                      <select name="b_surereach_geo_weight_<?php echo $geo_zone['geo_zone_id']; ?>_status" id="input-status<?php echo $geo_zone['geo_zone_id']; ?>" class="form-control">
                        <?php if (${'b_surereach_geo_weight_' . $geo_zone['geo_zone_id'] . '_status'}) { ?>
                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                        <option value="0"><?php echo $text_disabled; ?></option>
                        <?php } else { ?>
                        <option value="1"><?php echo $text_enabled; ?></option>
                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  
                </div>
                
                <?php } ?>
              </div>
            </div>
          </div>
          
                    <div align="center">          
			    <span style="color:#0000ff;">
	Extension: <b><?php echo $ext_title; ?></b>  <br />  
	Version: <b><?php echo $ext_version; ?></b>  <br />      
	E-Mail Support: <b><?php echo $dev_email; ?></b>
	            </span>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 