
if( items ){
	let a_ele = '', a_node, a_val,
		libre_scroll = document.getElementsByClassName('libre-scrolling');
	
	/**
	 * @param  {Element} link is each menu item link that is an anchor
	 */
	[...libre_scroll].forEach(function(link){
		/**
		 * @param  {Event} event to scroll to the anchor target element
		 */
		link.addEventListener('click', function(event){
			event.preventDefault();
			event.stopImmediatePropagation();
			a_node = 'href' in event.target.attributes ? event.target : event.target.getElementsByTagName('a')[0];
			if( ! a_node )
				return;
			
			a_val = a_node.attributes.href.value;
			a_ele = document.querySelector(a_val);
			a_ele.scrollIntoView({
				behavior: "smooth"
			});
		});
	});
}