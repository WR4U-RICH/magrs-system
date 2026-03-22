<?php include '../includes/header.php'; ?>
<?php include '../includes/nav.php'; ?>

<h1>MAGRS AI Governance Readiness Assessment</h1>

<p>
This short assessment helps organizations reflect on their awareness of artificial intelligence use in everyday work.

The assessment takes approximately 7 minutes.
Your responses are confidential.
</p>

<iframe 
  data-tally-src="https://tally.so/embed/Ek1zl2?alignLeft=1&hideTitle=1&transparentBackground=1&dynamicHeight=1" 
  loading="lazy" 
  width="100%" 
  height="1200" 
  frameborder="0" 
  marginheight="0" 
  marginwidth="0" 
  title="MAGRS Readiness Assessment">
</iframe>

<script>
var d=document,w="https://tally.so/widgets/embed.js",v=function(){
if(typeof Tally!=="undefined"){Tally.loadEmbeds();}
else{d.querySelectorAll("iframe[data-tally-src]:not([src])").forEach(function(e){
e.src=e.dataset.tallySrc;});}};
if(typeof Tally!=="undefined"){v();}
else if(d.querySelector('script[src="'+w+'"]')==null){
var s=d.createElement("script");
s.src=w;
s.onload=v;
s.onerror=v;
d.body.appendChild(s);}
</script>

<?php include '../includes/footer.php'; ?>