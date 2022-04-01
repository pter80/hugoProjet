
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
  
  
  
  /* POPUP POPULARITY  */
const btPopularity = 
	document.getElementById('btPopularity');
const openBtnPop =
  document.getElementById('openBtnPop');
const closeBtnPop =
  document.getElementById('closeBtnPop');
  
openBtnPop.addEventListener('click',
	function(){
  	    btPopularity.setAttribute('open', true);
  });

closeBtnPop.addEventListener('click',
	function(){
      	btPopularity.removeAttribute('open');
  });

