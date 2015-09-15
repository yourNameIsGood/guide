var nums = document.getElementsByClassName("tal f10 y-style");
for(i in nums){
	var count = nums[i].innerHTML;
	if(count>500){
		console.log(nums[i].innerHTML);
		var tr = (nums[i].parentNode);
		tr.style.backgroundColor="#ff0" ;

	}
}
