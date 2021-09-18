<?php
  $jumlah_fitur = '';
  $jumlah_hiden = '';
  $persen_data = '';

  if(isset($_SESSION['jumlahfitur']) && isset($_SESSION['jumlahhiden']) && isset($_SESSION['persendata'])) {
    $jumlah_fitur = $_SESSION['jumlahfitur'];
    $jumlah_hiden = $_SESSION['jumlahhiden'];
    $persen_data = $_SESSION['persendata'];
}
?>

<form class="container" method="POST" enctype="multipart/form-data" action="data.php">
  <div class="row">
    <div class="col-25">
      <label for="data">Data Load</label>
    </div>
    <div class="col-75">
      <input type="file" value="Upload" name="fileexcel">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="fitur">Jumlah Fitur</label>
    </div>
    <div class="col-75">
      <input type="text" id="fitur" name="jumlahfitur" placeholder="Wajib Diisi.." value="<?= $jumlah_fitur ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="hiden">Jumlah Hiddden Neuron</label>
    </div>
    <div class="col-75">
      <input type="text" id="hiden" name="jumlahhiden" placeholder="Wajib Diisi.." value="<?= $jumlah_hiden ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="persen">Persentase Pembagian Data</label>
    </div>
    <div class="col-75">
      <select id="persen" name="persendata">
        <option value="50" <?= $persen_data === 50 ? 'selected' : '' ?>>Data Training 50% : Data Testing 50%</option>
        <option value="80" <?= $persen_data === 80 ? 'selected' : '' ?>>Data Training 80% : Data Testing 20%</option>
        <option value="90" <?= $persen_data === 90 ? 'selected' : '' ?>>Data Training 90% : Data Testing 10%</option>
      </select>
    </div>
  </div>
  <div class="row">
    <br>
    <input type="submit" value="Submit">
  </div>
</form>