<div class="container pt-5">
    <h3><?= $title ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a>Absensi</a></li>
            <li class="breadcrumb-item "><a href="<?= base_url('absensi'); ?>">List Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?php
                    //create form
                    $attributes = array('id' => 'FrmEditAbsensi', 'method' => "post", "autocomplete" => "off");
                    echo form_open('', $attributes);
                    ?>
                    <!-- edit nama -->
                    <div class="form-group row">
                        <label for="Nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" id="IdMhsw" name="IdMhsw" value=" <?= $data_absensi->IdMhsw; ?>">
                            <input type="text" class="form-control" id="Nama" name="Nama" value=" <?= $data_absensi->Nama; ?>">
                            <small class="text-danger">
                                <?php echo form_error('Nama') ?>
                            </small>
                        </div>
                    </div>

                    <!-- edit kehadiran -->
                    <div class="form-group row">
                        <label for="Kehadiran" class="col-sm-2 col-form-label">Kehadiran</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="Kehadiran" name="Kehadiran">
                                <option value="Hadir" selected disabled>Pilih</option>
                                <option value="Hadir" <?php if ($data_absensi->Kehadiran == "Hadir") : echo "selected";
                                                        endif; ?>>Hadir</option>
                                <option value="izin" <?php if ($data_absensi->Kehadiran == "izin") : echo "selected";
                                                        endif; ?>>izin</option>
                                <option value="sakit" <?php if ($data_absensi->Kehadiran == "sakit") : echo "selected";
                                                        endif; ?>>sakit</option>
                                <option value="tanpa keterangan" <?php if ($data_absensi->Kehadiran == "tanpa keterangan") : echo "selected";
                                                                    endif; ?>>tanpa keterangan</option>
                            </select>
                            <small class="text-danger">
                                <?php echo form_error('Kehadiran') ?>
                            </small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10 offset-md-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a class="btn btn-secondary" href="javascript:history.back()">Kembali</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>