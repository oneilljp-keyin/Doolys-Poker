function entrypopup(link, wth, hgt, win_name) {
  var n_link     = link;
  var n_wth      = wth;
  var n_hgt      = hgt; 
  var n_win_name = win_name;

  var n_left_pos = (screen.width / 2) - (n_wth / 2);

  window.open(link,' + n_win_name + ','width=' + n_wth + 'px,height=' +n_hgt+ 'px,left=' +n_left_pos+ ',scrollbars=no,status=no,directories=no,location=no,menubar=no,resizable=no,toolbar=no,title=yes'); 

}
