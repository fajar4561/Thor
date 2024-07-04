

<?php foreach (range(1, 18) as $key) { ?>
  
<script type="text/javascript">
  var rupiah<?php echo $key."$data[id]";?> = document.getElementById('rupiah'+<?php echo $key."$data[id]";?>);
  rupiah<?php echo $key."$data[id]";?>.addEventListener('keyup', function(e){
    rupiah<?php echo $key."$data[id]";?>.value = formatRupiah(this.value, 'Rp. ');
  });

  function formatRupiah(angka<?php echo $key."$data[id]";?>, prefix){
    var number_string<?php echo $key."$data[id]";?> = angka<?php echo $key."$data[id]";?>.replace(/[^,\d]/g, '').toString(),
    split<?php echo $key."$data[id]";?>           = number_string<?php echo $key."$data[id]";?>.split(','),
    sisa<?php echo $key."$data[id]";?>           = split<?php echo $key."$data[id]";?>[0].length % 3,
    rupiah<?php echo $key."$data[id]";?>          = split<?php echo $key."$data[id]";?>[0].substr(0, sisa<?php echo $key."$data[id]";?>),
    ribuan<?php echo $key."$data[id]";?>          = split<?php echo $key."$data[id]";?>[0].substr(sisa<?php echo $key."$data[id]";?>).match(/\d{3}/gi);

    if(ribuan<?php echo $key."$data[id]";?>){
      separator<?php echo $key."$data[id]";?> = sisa<?php echo $key."$data[id]";?> ? '.' : '';
      rupiah<?php echo $key."$data[id]";?> += separator<?php echo $key."$data[id]";?> + ribuan<?php echo $key."$data[id]";?>.join('.');
    }

    rupiah<?php echo $key."$data[id]";?> = split<?php echo $key."$data[id]";?>[1] != undefined ? rupiah<?php echo $key."$data[id]";?> + ',' + split<?php echo $key."$data[id]";?>[1] : rupiah<?php echo $key."$data[id]";?>;
    return prefix == undefined ? rupiah<?php echo $key."$data[id]";?> : (rupiah<?php echo $key."$data[id]";?> ? 'Rp. ' + rupiah<?php echo $key."$data[id]";?> : '');
  }
</script>

<?php } ?>