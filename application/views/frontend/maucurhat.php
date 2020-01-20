<!-- Contact Us Page 2 Area Start Here -->
<div class="contact-us-page2-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <h2 class="title-default-left title-bar-high">Informasi</h2>
                <div class="contact-us-info2">
                    <ul>
                        <li><i class="fa fa-map-marker" aria-hidden="true"></i><?= $kontak[0]['alamat'] ?></li>
                        <li><i class="fa fa-phone" aria-hidden="true"></i><?= $kontak[0]['hape'] ?></li>
                        <li><i class="fa fa-envelope-o" aria-hidden="true"></i><?= $kontak[0]['email'] ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h2 class="title-default-left title-bar-high">Hubungi Kami</h2>
                    </div>
                </div>
                <div class="row">
                    <?= $this->session->flashdata('notif') ?>
                    <div class="contact-form2">
                        <form id="contact-form" action="<?= base_url() . 'home/komentar_tambah' ?>" method="post">
                            <input type="hidden" name="slug" value="<?= $this->uri->segment(2) ?>">
                            <input type="hidden" name="website" value="kontak">
                            <input type="hidden" name="id_post" value="0">
                            <fieldset>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Nama*" class="form-control" name="nama" id="form-name" data-error="Name field is required" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="email" placeholder="Email*" class="form-control" name="email" id="form-email" data-error="Email field is required" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <textarea placeholder="Pesan*" class="textarea form-control" name="komentar" id="form-message" rows="8" cols="20" data-error="Message field is required" required></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-sm-12">
                                    <div class="form-group margin-bottom-none">
                                        <button type="submit" class="default-big-btn">Kirim</button>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-6 col-sm-12">
                                    <div class='form-response'></div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact Us Page 2 Area End Here -->