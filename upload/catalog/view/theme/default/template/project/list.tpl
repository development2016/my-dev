<?php echo $header; 
$route = 'index.php?route=project/view';
$quotation = '&quotation=';
$belong = '&belong=';


?>
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

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Quotation</th>
            <th>Date Quotation</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i =0; foreach ($all as $key => $document) { $i++;?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $document['quotation_no']; ?></td>
            <td><?php echo $document['date_create']; ?></td>
            <td>
                <a href="<?php echo $base; ?>/<?php echo $route ?><?php echo $quotation ?><?php echo $document['quotation_no']; ?><?php echo $belong ?><?php echo $document['enter_by']; ?>">View</a>
                <br>
               
            </td>
          </tr>
            
          <?php } ?>
        </tbody>
        
      </table>


      <?php echo $content_bottom; ?>
      </div>
    <?php echo $column_right; ?>
    </div>
</div>
<?php echo $footer; ?>