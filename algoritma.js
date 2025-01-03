function likeUnlike(journalId) {
  var formData = new FormData(document.getElementById('likeForm' + journalId));
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          // Tanggapan dari server berhasil diterima, lakukan sesuatu jika perlu
          var response = this.responseText;
          console.log(response);
          // Refresh halaman atau lakukan tindakan lain jika diperlukan
          window.location.reload();
      }
  };
  xhr.open("POST", "like.php", true);
  xhr.send(formData);
}
