<style type="text/css">
  

html {
  line-height: 1.15; /* 1 */
  -ms-text-size-adjust: 100%; /* 2 */
  -webkit-text-size-adjust: 100%; /* 2 */
  font-family:Arial, Helvetica, sans-serif !important;
}

body {
  background: rgb(255, 255, 255); 
}
page {
  background: white;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
}
page[size="A4"] {  
  width: 21cm;
  height: auto; 
  padding: 5mm;
}
page[size="A4"][layout="portrait"] {
  width: 29.7cm;
  height: 21cm;  
}
page[size="A3"] {
  width: 29.7cm;
  height: 42cm;
}
page[size="A3"][layout="portrait"] {
  width: 42cm;
  height: 29.7cm;  
}
page[size="A5"] {
  width: 14.8cm;
  height: 21cm;
}
page[size="A5"][layout="portrait"] {
  width: 21cm;
  height: 14.8cm;  
}
@media print {
  body, page {
    margin: 0;
    box-shadow: 0;
  }
}
 @page {
  size: auto;
  margin: 0;
       }

tr.border_bottom td {
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);


}

@media print {
  #printPageButton {
    display: none;
  }
}

.print {
  margin-top: 20px;
  text-align: right;
  

}

.btn-print {
    padding: 10;
    color: #ffffff;
    font-size: 14px;
    cursor: pointer;
    background-color: #1e88e5;
}
</style>

<body >
  <page size="A4">

<div>
    <span style="font-size: 30px;font-weight: bold;"><?php echo $config_name; ?></span>
    <span style="font-size: 11px;">Co.No.  , GST Registeration No. : </span>
    <br>
    <span style="font-size: 15px;">
      <?php echo $config_address; ?>
    </span>
    <br>
    <span style="font-size: 15px;">
      <span style="font-size: 15px;font-weight: bold;">TEL : </span> <?php echo $config_telephone; ?>
      &nbsp;
      <span style="font-size: 15px;font-weight: bold;">FAX : </span> <?php echo $config_fax; ?>
      &nbsp;
      <span style="font-size: 15px;font-weight: bold;">EMAIL : </span> <?php echo $config_email; ?>

    </span>

</div>
<p></p>
<br>
<div>
    <h2 style="font-size: 22px;font-weight: bold;text-align: center;"><?php echo $qt_title; ?></h2>
</div>
<hr style="   border: 0;
    height: 0;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    border-bottom: 1px solid rgba(255, 255, 255, 0.3);
    ">
<p></p>
<br>

<div>
  <table border="0" width="100%">
      <tr>
          <td style="width: 130px;vertical-align: top;"><span style="font-size: 15px;">To</span></td>
          <td style="width: 5px;vertical-align: top;"><span style="font-size: 15px;">:</span></td>
          <td style="width: 430px;">
         

                                
          </td>
          <td style="width: 80px;vertical-align: top;"><span style="font-size: 15px;"><?php echo $qt_no; ?></span></td>
          <td style="width: 5px;vertical-align: top;"><span style="font-size: 15px;">:</span></td>
          <td style="width: 130px;vertical-align: top;">
              
            <span style="font-weight: bold;"><?php echo $all[0]['quotation_no'];?></span>
            
          </td>
      </tr>




      <tr >
          <td style="width: 130px;vertical-align: top;" rowspan="2"><span style="font-size: 15px;" >Delivery Address</span></td>
          <td style="width: 5px;vertical-align: top;" rowspan="2">:</td>
          <td style="width: 430px;" rowspan="2">
            <span style="font-size: 15px;">                                    


                                    </span>


          </td>
          <td style="vertical-align: top;width: 80px;"><span style="font-size: 15px;">Date</span></td>
          <td style="width: 5px;vertical-align: top;"><span style="font-size: 15px;">:</span></td>
          <td style="vertical-align: top;width: 130px;"><span style="font-size: 15px;"><?= date('d-M-Y'); ?></span></td>
      </tr>




  </table>
</div>
<p></p>
<br>

<div>
  <table width="100%" border="0" >
      <tr>
          <td style="padding: 10px;background-color: #dedede;"><span style="font-size: 15px;font-weight: bold;">NO</span></td>
          <td style="padding: 10px;background-color: #dedede;""><span style="font-size: 15px;font-weight: bold;"><?php echo $column_name; ?></span></td>
          <td style="padding: 10px;background-color: #dedede;""><span style="font-size: 15px;font-weight: bold;"><?php echo $column_model; ?></span></td>
          <td style="padding: 10px;background-color: #dedede;""><span style="font-size: 15px;font-weight: bold;"><?php echo $column_quantity; ?></span></td>
          <td style="padding: 10px;background-color: #dedede;""><span style="font-size: 15px;font-weight: bold;"><?php echo $column_price; ?></span></td>
          <td style="padding: 10px;background-color: #dedede;""><span style="font-size: 15px;font-weight: bold;"><?php echo $column_total; ?></span></td>
          

      </tr>


      <?php $i= 0; foreach ($all[0]['quotation_data']['products'] as $key => $document) { $i++;?>
      <tr class="border_bottom">
          <td style="padding: 10px;width: 10px;">
            <span style="font-size: 15px;"><?= $i; ?></span>
          </td>
          <td style="padding: 10px;width: 300px;">
            <?php echo $document['name']; ?>
          </td>
          <td style="padding: 10px;width: 20px;text-align: right;">
            <?php echo $document['model']; ?>
          </td>
          <td style="padding: 10px;width: 20px;text-align: right;">
            <?php echo $document['quantity']; ?>
          </td>
          <td style="padding: 10px;width: 20px;text-align: right;">
             <?php echo $document['price']; ?>
          </td>
          <td style="padding: 10px;width: 20px;text-align: right;">
            <?php echo $document['total']; ?>
          </td>

      </tr>


      <?php } ?>
  </table>
</div>
<br>


<div>
  <table width="100%" border="0">

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
        <td colspan="4" class="text-left"><strong><?php echo $document_totals['title']; ?>:</strong></td>
        <td class="text-right"><?php echo $document_totals['text']; ?></td>
      </tr>
      <?php } ?>


  </table>
  <br>


</div>
<div class="print">

  <a class="btn-print" id="printPageButton" onclick="javascript:window.print();" title="Print">PRINT</a>

</div>
 
 </page>
</body >
  







