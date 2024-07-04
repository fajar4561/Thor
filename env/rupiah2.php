

<?php foreach (range(1, 18) as $key) { ?>
  
<script type="text/javascript">
  var rupiah<?php echo $key;?> = document.getElementById('rupiah'+<?php echo $key;?>);
  rupiah<?php echo $key;?>.addEventListener('keyup', function(e){
    rupiah<?php echo $key;?>.value = formatRupiah(this.value, 'Rp. ');
  });

  function formatRupiah(angka<?php echo $key;?>, prefix){
    var number_string<?php echo $key;?> = angka<?php echo $key;?>.replace(/[^,\d]/g, '').toString(),
    split<?php echo $key;?>           = number_string<?php echo $key;?>.split(','),
    sisa<?php echo $key;?>           = split<?php echo $key;?>[0].length % 3,
    rupiah<?php echo $key;?>          = split<?php echo $key;?>[0].substr(0, sisa<?php echo $key;?>),
    ribuan<?php echo $key;?>          = split<?php echo $key;?>[0].substr(sisa<?php echo $key;?>).match(/\d{3}/gi);

    if(ribuan<?php echo $key;?>){
      separator<?php echo $key;?> = sisa<?php echo $key;?> ? '.' : '';
      rupiah<?php echo $key;?> += separator<?php echo $key;?> + ribuan<?php echo $key;?>.join('.');
    }

    rupiah<?php echo $key;?> = split<?php echo $key;?>[1] != undefined ? rupiah<?php echo $key;?> + ',' + split<?php echo $key;?>[1] : rupiah<?php echo $key;?>;
    return prefix == undefined ? rupiah<?php echo $key;?> : (rupiah<?php echo $key;?> ? 'Rp. ' + rupiah<?php echo $key;?> : '');
  }
</script>

<?php } ?>