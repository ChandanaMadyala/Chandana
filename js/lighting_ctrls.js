document.write(`




<label for="hdris" class="hdris-label">HDRI:</label>
<select id="hdris">
  <option value="../../hdri/ballroom_1k.hdr;../../hdri/ballroom_1k.jpg">ballroom</option>
  <option value="../../hdri/anniversary_lounge_1k.hdr;../../hdri/anniversary_lounge_1k.jpg">anniversary lounge</option>
  <option value="../../hdri/autoshop_01_1k.hdr;../../hdri/autoshop_01_1k.jpg">autoshop</option>
  <option value="../../hdri/studio003small.hdr;../../hdri/studio003small.jpg">studio small</option>
  <option value="../../hdri/kiara_interior_1k.hdr;../../hdri/kiara_interior_1k.jpg">kiara interior</option>
  <option value="../../hdri/lebombo_1k.hdr;../../hdri/lebombo_1k.jpg">lebombo</option>
  <option value="../../hdri/wooden_lounge_1k.hdr;../../hdri/wooden_lounge_1k.jpg">wooden lounge</option>
  
</select>

<label for="skybox_on_off">skybox:</label>
    <input id="skybox_on_off" type="checkbox"  unchecked>
    <label for="exposure">exposure:</label>
    <input id="exposure" type="range" step="0.01" min="0" max="2" value="1">
    <span id="exposure-value">1</span>



   

<script>

   

    let exposureDisplay = document.querySelector("#exposure-value");
        document.querySelector('#exposure').addEventListener('input', (event) => {
        modelviewer.setAttribute('exposure',event.target.value);
        exposureDisplay.textContent = event.target.value;
        });


        let x;
        let y;
        let z;

        document.querySelector('#hdris').addEventListener('input', (event) => {
            x = event.target.value;
            temp = new Array();
            temp = x.split(";");
            y=temp[0];
            z=temp[1];

          modelviewer.setAttribute('environment-image',y);
          modelviewer.setAttribute('skybox-image',z);
          console.log(x);
        });

        
        
        document.querySelector('#skybox_on_off').addEventListener('input',(event) =>{

           
            
            if (document.getElementById("skybox_on_off").checked){
                
                console.log(z);
                console.log("true");
                

             }
             else {
                
                console.log("flase");
                modelviewer.skyboxImage = null;
             }
            

        })
</script>
`);