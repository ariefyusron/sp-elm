<?php

?>

<form class="container">
  <div class="row">
    <div class="col-25">
      <label for="data">Data Load</label>
    </div>
    <div class="col-75">
      <input type="file" value="Upload">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="fitur">Jumlah Fitur</label>
    </div>
    <div class="col-75">
      <input type="text" id="fitur" name="jumlahfitur" placeholder="Wajib Diisi..">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="hiden">Jumlah Hiddden Neuron</label>
    </div>
    <div class="col-75">
      <input type="text" id="hiden" name="jumlahhiden" placeholder="Wajib Diisi..">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="persen">Persentase Pembagian Data</label>
    </div>
    <div class="col-75">
      <select id="persen" name="persendata">
        <option value="50">Data Training 50% : Data Testing 50%</option>
        <option value="80">Data Training 80% : Data Testing 20%</option>
        <option value="90">Data Training 90% : Data Testing 10%</option>
      </select>
    </div>
  </div>
  <div class="row">
    <br>
    <input type="submit" value="Submit">
  </div>
</form>