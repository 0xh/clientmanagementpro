window.onload = function(){
  var cls_behave = document.getElementsByClassName('tab_behave');
  
  for( i=0;i< cls_behave.length ; i++){
    var editor = new Behave({
    
      textarea: 		cls_behave[i],
      replaceTab: 	true,
      softTabs: 		true,
      tabSize: 		8,
      autoOpen: 		true,
      overwrite: 		true,
      autoStrip: 		true,
      autoIndent: 	true
    });
  }
  
};