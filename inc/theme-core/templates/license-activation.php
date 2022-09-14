<div class="wrap wing license-page">

<?php
  $license_data = get_option( 'wing_lic_data' );
  $date_expiry = new DateTime( $license_data['date_expiry'] );

  if ( $date_expiry > new DateTime( '2030-01-01' ) ) {
    $date_expiry = 'Seumur Hidup';
  } else {
    $date_expiry = $date_expiry->format( 'd F Y' );
  }

  if ( ! empty( $license_data ) ) :
?>
  <h1>Informasi Lisensi</h1>
  <p>Terima kasih atas kepercayaan Anda pada Winter Glow, semoga Anda menyukai template ini! :)</p>
  
  <table class="form-table">
    <tr>
      <th>Status lisensi</th>
      <td><?php echo esc_html( ucfirst( $license_data['status'] ) ); ?></td>
    </tr>
    <tr>
      <th>Tanggal jatuh tempo</th>
      <td><?php echo $date_expiry; ?></td>
    </tr>
    <tr>
      <th>License key</th>
      <td><?php echo esc_html( $license_data['lic_key'] ); ?></td>
    </tr>
    <tr>
      <th>Email</th>
      <td><?php echo esc_html( $license_data['email'] ); ?></td>
    </tr>
  </table>

  <a href="<?php echo esc_url( 'https://forms.gle/2mwLe2HBNQzM5dXA7' ); ?>" class="feedback-link" target="_blank">Beri feedback</a>
<?php endif; ?>



<?php if ( empty( $license_data ) ) : ?>
  <h1>Aktivasi Lisensi</h1>
  <p>Silahkan masukkan lisensi untuk melakukan aktivasi.</p>
  <p>Anda dapat menghubungi nomor WhatsApp <a href="https://api.whatsapp.com/send?phone=6282362361344&text=Halo+kak,+saya+ingin+melakukan+order+lisensi+tema+Winter+Glow">0823 6236 1344</a> jika belum menerima email tersebut.</p>
<?php elseif ( $license_data['status'] !== 'active' ) : ?>
  <h1>Ganti Lisensi</h1>
  <p>Lisensi ini tidak aktif. Anda dapat mengganti lisensi lain dengan melakukan aktivasi ulang.</p>
  <p>Jika berhasil, lisensi terbaru akan digunakan.</p>
<?php endif; ?>

<?php if ( empty( $license_data ) || $license_data['status'] !== 'active' ) : ?>
  <form action="" method="post">
    <?php wp_nonce_field( 'activate_license', 'wing_nonce' ); ?>

    <table class="form-table">
      <tr>
        <th class="license-key-label"><label for="wing-license-key">License Key</label></th>
        <td><input class="regular-text" type="text" id="wing-license-key" name="wing_license_key"></td>
      </tr>
    </table>

    <p class="submit">
      <input type="submit" class="button-primary" value="Activate license">
    </p>
  </form>
<?php endif; ?>

</div>