<template>
		<div class="row justify-content-center">
			<div class="col">
				<div class="d-flex justify-content-center spinner">
				  <div class="spinner-border text-info" style="width: 4rem; height: 4rem;" role="status">
				    <span class="sr-only">Loading...</span>
				  </div>
				</div>
			</div>
		</div>
</template>
<style>
	.spinner{
    position:fixed;
    z-index:99;/* make higher than whatever is on the page */
    top:0;
    left:0;
    right:0;
    bottom:0;
    margin:auto;
    width:100px;
    height:100px;
}
</style>
