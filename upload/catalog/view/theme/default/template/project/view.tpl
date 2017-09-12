<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>


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
              <td align="right"><b><?php echo $all[0]['quotation_no'];?> </b></td>
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
                        <?php $i= 0; foreach ($all[0]['quotation_data']['products'] as $key => $document) { $i++;?>
                        <tr>
                            <td class="text-left"><?php echo $document['name']; ?></td>
                            <td class="text-left"><?php echo $document['model']; ?></td>
                            <td class="text-right"><?php echo $document['quantity']; ?></td>
                            <td class="text-right"><?php echo $document['price']; ?></td>
                            <td class="text-right"><?php echo $document['total']; ?></td>
                          </tr>
                        
                        <?php } ?>
                        </tbody>
                      </table>
                </td>
            </tr>
            <tr>
              <td>
                
                <table class="table table-borderless">
                      <?php foreach ($all[0]['quotation_data']['vouchers'] as $key => $document_vouchers) { ?>
                      <tr>
                        <td class="text-left"><?php echo $document_vouchers['description']; ?></td>
                        <td class="text-left"></td>
                        <td class="text-right">1</td>
                        <td class="text-right"><?php echo $document_vouchers['amount']; ?></td>
                        <td class="text-right"><?php echo $document_vouchers['amount']; ?></td>
                      </tr>
                      <?php } ?>
                      <?php foreach ($all[0]['quotation_data']['totals'] as $key => $document_totals) { ?>
                      <tr>
                        <td colspan="4" class="text-right"><strong><?php echo $document_totals['title']; ?>:</strong></td>
                        <td class="text-right"><?php echo $document_totals['text']; ?></td>
                      </tr>
                      <?php } ?>

                  </table>


              </td>
            </tr>
   

        </table>


      <?php echo $content_bottom; ?>
      </div>
    <?php echo $column_right; ?>
    </div>
</div>
<?php echo $footer; ?>