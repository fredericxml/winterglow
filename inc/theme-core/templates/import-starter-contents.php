<div class="wrap wing">
  <h1>Impor Konten Demo</h1>

  <p class="notice notice-error" style="padding-top: 0.75rem; padding-bottom: 0.75rem;">PERHATIAN! Proses ini sebaiknya hanya digunakan pada instalasi baru karena dapat mengubah beberapa pengaturan kembali ke pengaturan awal. Pengaturan yang sudah terubah <b>tidak dapat</b> dikembalikan!</p>

  <p>Hanya di template Winter Glow, Anda tidak perlu memikirkan konten demo karena semua konten demo akan secara otomatis diimport ke website Anda! Dengan begitu, Anda bisa langsung mengubah konten-konten di website dengan sangat mudah.</p>
  
  <p>Meskipun konten demo diimpor secara otomatis ketika template diinstal pertama kali, Anda mungkin perlu mengimpor kembali konten demo karena hal tertentu (misalnya semua konten terhapus secara tidak sengaja).</p>
  
  <p>Jika itu terjadi, Anda dapat mengimpor kembali konten tersebut. Namun perlu <b>diperhatikan</b> bahwa jika Anda sudah pernah mengupdate konten Anda sebelumnya, proses ini bisa <b>menimpa</b> konten tersebut. Tekan tombol <b>Import Sekarang</b> untuk memulai proses impor.</p>

  <p>NB: Setelah tombol ditekan, proses impor akan langsung berjalan.</p>

  <form action="" method="post">
    <?php wp_nonce_field( 'import_starter_contents', 'wing_nonce' ); ?>
      
    <p class="submit">
      <input type="submit" class="button-primary" value="Impor Sekarang">
    </p>
  </form>
</div>