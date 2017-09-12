<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
    	<h1><?php echo $heading_title; ?></h1>
        <table class="table table-bordered" >
            <tr>
              <td colspan="2">
                <h2><b><?php echo $config_name; ?></b></h2> 
                <?php echo $config_address; ?> 
                <br>
                <b>Tel : </b><?php echo $config_telephone; ?> 
                <b>Fax : </b><?php echo $config_fax; ?>
                <b>Email : </b><?php echo $config_email; ?>
              </td>

            </tr>
            <tr>
              <td align="center">
                <h3><b><?php echo $qt_title; ?></b></h3>
              </td>
            </tr>
            <tr>
              <td>
                <table class="table table-borderless">
                  <tr>
                    <td>To : </td>
                    <td>{ company buyer} 
                      <br>
                <b>Attention To </b> : {example}
                <br>
                <b>Contact </b> : {example}
                <br>
                <b>Email </b> : {example}
              </td>
              <td align="right"><?php echo $qt_no; ?> : </td>
              <td align="right"><b></b></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td align="right"><?php echo $qt_date; ?> : </td>
                    <td align="right"><?= date('d-M-Y'); ?></td>
                  </tr>
                  <tr>
                    <td>Delivery Address : </td>
                    <td>
                      { company buyer} 
                      <br>
                { company address} 
              </td>
                    <td></td>
                    <td></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
                <td>

                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <td class="text-left"><?php echo $column_name; ?></td>
                            <td class="text-left"><?php echo $column_model; ?></td>
                            <td class="text-right"><?php echo $column_quantity; ?></td>
                            <td class="text-right"><?php echo $column_price; ?></td>
                            <td class="text-right"><?php echo $column_total; ?></td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($products as $product) { ?>
                          <tr>
                            <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>

                              </td>
                            <td class="text-left"><?php echo $product['model']; ?></td>
                            <td class="text-right"><?php echo $product['quantity']; ?></td>
                            <td class="text-right"><?php echo $product['price']; ?></td>
                            <td class="text-right"><?php echo $product['total']; ?></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>


                </td>
            </tr>
            <tr>
              <td>
                
                <table class="table table-borderless">
                      <?php foreach ($vouchers as $voucher) { ?>
                      <tr>
                        <td class="text-left"><?php echo $voucher['description']; ?></td>
                        <td class="text-left"></td>
                        <td class="text-right">1</td>
                        <td class="text-right"><?php echo $voucher['amount']; ?></td>
                        <td class="text-right"><?php echo $voucher['amount']; ?></td>
                      </tr>
                      <?php } ?>
                      <?php foreach ($totals as $total) { ?>
                      <tr>
                        <td colspan="4" class="text-right"><strong><?php echo $total['title']; ?>:</strong></td>
                        <td class="text-right"><?php echo $total['text']; ?></td>
                      </tr>
                      <?php } ?>

                  </table>



              </td>
            </tr>
   

        </table>



        

      <div class="buttons">

        <div class="pull-right">
          <a href="<?php echo $generate_qt; ?>" class="btn btn-primary">Generate Quotation</a>
        </div>
      </div>



      <?php echo $content_bottom; ?>
      </div>
    <?php echo $column_right; ?>
    </div>
</div>
<?php echo $footer; ?>