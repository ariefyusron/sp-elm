<?php
  session_start();
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
      <input type="text" id="fitur" name="jumlahfitur" placeholder="Wajib Diisi.." value="<?= $_SESSION['jumlahfitur'] ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="hiden">Jumlah Hiddden Neuron</label>
    </div>
    <div class="col-75">
      <input type="text" id="hiden" name="jumlahhiden" placeholder="Wajib Diisi.." value="<?= $_SESSION['jumlahhiden'] ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="persen">Persentase Pembagian Data</label>
    </div>
    <div class="col-75">
      <select id="persen" name="persendata">
        <option value="50" <?= $_SESSION['persendata'] === 50 ? 'selected' : '' ?>>Data Training 50% : Data Testing 50%</option>
        <option value="80" <?= $_SESSION['persendata'] === 80 ? 'selected' : '' ?>>Data Training 80% : Data Testing 20%</option>
        <option value="90" <?= $_SESSION['persendata'] === 90 ? 'selected' : '' ?>>Data Training 90% : Data Testing 10%</option>
      </select>
    </div>
  </div>
  <div class="row">
    <br>
    <input type="submit" value="Submit">
  </div>
</form>