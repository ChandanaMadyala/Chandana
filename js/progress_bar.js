document.write(`
  <div class="progress-bar" slot="progress-bar">
    <div class="update-bar"></div>
  </div>
`);

const onProgress = function(event) {

  const progressBar = event.target.querySelector('.progress-bar');
  const updatingBar = event.target.querySelector('.update-bar');
  updatingBar.style.width = (event.detail.totalProgress*100)+'%';
  progressBar.style.visibility = "visible";
  if (event.detail.totalProgress == 1) {
    progressBar.classList.add('hide');
    progressBar.style.visibility = "hidden";
  }
};
