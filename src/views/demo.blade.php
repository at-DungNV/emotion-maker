<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1> {{$imgurl}}</h1>
    @if (!empty($imgurl))
      <?php $x = $imgurl;?>
    @else
      <?php $x = $imgurl . "khong";?>
    @endif

    <?php echo $x; ?>
  </body>
</html>
