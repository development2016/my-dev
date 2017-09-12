<?php if ($error_warning) { ?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($payment_methods) { ?>
<p><?php echo $text_payment_method; ?></p>
<?php foreach ($payment_methods as $payment_method) { ?>
<div class="radio">
  <label>
    <?php if ($payment_method['code'] == $code || !$code) { ?>
    <?php $code = $payment_method['code']; ?>
    <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked" />
    <?php } else { ?>
    <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" />
    <?php } ?>
    <?php echo $payment_method['title']; ?>
    <?php if ($payment_method['terms']) { ?>
    (<?php echo $payment_method['terms']; ?>)
    <?php } ?>
  </label>
</div>
<?php } ?>
<?php } ?>
<p><strong><?php echo $text_comments; ?></strong></p>
<p>
  <textarea name="comment" rows="8" class="form-control"><?php echo $comment; ?></textarea>
</p>

            <?php if ($apply_checkout_status) { ?>
                <div id="discount-message"></div>
                  
                <div id="discounts-forms" style="margin-bottom: 15px; float: left;">
                  <?php if ($coupon_status) { ?>
                  <div id = "coupon-form">
                    <label class="control-label" for="input-coupon"><strong><?php echo $use_coupon; ?></strong></label>
                    <div class="input-group">
                      <input type="text" name="coupon" value="<?php echo $coupon; ?>" placeholder="<?php echo $entry_coupon; ?>" id="input-coupon" class="form-control" />
                      <span class="input-group-btn">
                      <input type="button" value="<?php echo $button_coupon; ?>" id="button-coupon" data-loading-text="<?php echo $text_loading; ?>"  class="btn btn-primary" />
                      </span></div>
                  </div>
                  <?php } ?>
                  
                  <?php if ($voucher_status) { ?>
                  <div id = "voucher-form">
                    <label class="control-label" for="input-voucher"><strong><?php echo $use_voucher; ?></strong></label>
                    <div class="input-group">
                      <input type="text" name="voucher" value="<?php echo $voucher; ?>" placeholder="<?php echo $entry_voucher; ?>" id="input-voucher" class="form-control" />
                      <span class="input-group-btn">
                      <input type="submit" value="<?php echo $button_voucher; ?>" id="button-voucher" data-loading-text="<?php echo $text_loading; ?>"  class="btn btn-primary" />
                      </span></div>
                  </div>
                  <?php } ?>
    
                  <?php if ($reward_status) { ?>
                  <div id = "reward-form">
                    <label class="control-label" for="input-reward"><strong><?php echo $use_reward; ?></strong></label>
                    <div class="input-group">
                      <input type="text" name="reward" value="<?php echo $reward; ?>" placeholder="<?php echo $entry_reward; ?>" id="input-reward" class="form-control" />
                      <span class="input-group-btn">
                      <input type="submit" value="<?php echo $button_reward; ?>" id="button-reward" data-loading-text="<?php echo $text_loading; ?>"  class="btn btn-primary" />
                      </span></div>
                  </div>
                  <?php } ?>
                </div>
                
                <script type="text/javascript"><!--
                $('#button-coupon').on('click', function() {
                	$.ajax({
                		url: 'index.php?route=total/coupon/coupon',
                		type: 'post',
                		data: 'coupon=' + encodeURIComponent($('input[name=\'coupon\']').val()),
                		dataType: 'json',
                		beforeSend: function() {
                			$('#button-coupon').button('loading');
                		},
                		complete: function() {
                			$('#button-coupon').button('reset');
                		},
                		success: function(json) {
                			$('.alert').remove();
                
                			if (json['error']) {
                				$('#discount-message').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                			}
                
                			if (json['success']) {
                			    $('#cart > ul').load('index.php?route=common/cart/info ul li');
                                $('#discount-message').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                			}
                		}
                	});
                });
                //--></script>
    
                <script type="text/javascript"><!--
                $('#button-voucher').on('click', function() {
                    $.ajax({
                        url: 'index.php?route=total/voucher/voucher',
                        type: 'post',
                        data: 'voucher=' + encodeURIComponent($('input[name=\'voucher\']').val()),
                        dataType: 'json',
                        beforeSend: function() {
                          $('#button-voucher').button('loading');
                        },
                        complete: function() {
                          $('#button-voucher').button('reset');
                        },
                        success: function(json) {
                          $('.alert').remove();
                    
                          if (json['error']) {
                             $('#discount-message').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                          }
                        
                          if (json['success']) {
                             $('#cart > ul').load('index.php?route=common/cart/info ul li');
                             $('#discount-message').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                		  }
                       }
                    });
                });
                //--></script>
    
                <script type="text/javascript"><!--
                $('#button-reward').on('click', function() {
                	$.ajax({
                		url: 'index.php?route=total/reward/reward',
                		type: 'post',
                		data: 'reward=' + encodeURIComponent($('input[name=\'reward\']').val()),
                		dataType: 'json',
                		beforeSend: function() {
                			$('#button-reward').button('loading');
                		},
                		complete: function() {
                			$('#button-reward').button('reset');
                		},
                		success: function(json) {
                			$('.alert').remove();
                
                          if (json['error']) {
                            $('#discount-message').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                          }
                    
            			  if (json['success']) {
                            $('#cart > ul').load('index.php?route=common/cart/info ul li');
                            $('#discount-message').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            			  }
                		}
                	});
                });
                //--></script>
    
                <style type="text/css">
                <!--
                    <?php if ($coupon_status && $voucher_status && $reward_status) { ?>
                    #coupon-form, #voucher-form, #reward-form {
                        float:left;
                        width:32.33%;
                        margin:0.5%;"
                    }
                    <?php } else if (($coupon_status && $voucher_status) || ($coupon_status && $reward_status) || ($voucher_status && $reward_status)) { ?>
                    #coupon-form, #voucher-form, #reward-form {
                        float:left;
                        width:49%;
                        margin:0.5%;"
                    }
                    <?php } else if ($coupon_status ||  $voucher_status || $reward_status) { ?>
                    #coupon-form, #voucher-form, #reward-form {
                        float:left;
                        width:99%;
                        margin:0.5%;"
                    }
                    <?php } ?>

                    .buttons {
                        float:right;
                    }
                -->
                </style>
            <?php } ?>
            
<?php if ($text_agree) { ?>
<div class="buttons">
  <div class="pull-right"><?php echo $text_agree; ?>
    <?php if ($agree) { ?>
    <input type="checkbox" name="agree" value="1" checked="checked" />
    <?php } else { ?>
    <input type="checkbox" name="agree" value="1" />
    <?php } ?>
    &nbsp;
    <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" />
  </div>
</div>
<?php } else { ?>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" />
  </div>
</div>
<?php } ?>
