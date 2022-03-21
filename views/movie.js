
/* POPUP TRAILER   */
const btTrailer = 
	document.getElementById('btTrailer');
const openBtn =
  document.getElementById('openBtn');
const closeBtn =
  document.getElementById('closeBtn');
  
openBtn.addEventListener('click',
	function(){
  	    btTrailer.setAttribute('open', true);
  })

closeBtn.addEventListener('click',
	function(){
      	btTrailer.removeAttribute('open');
  })

