export default function e(e){if(!/^\d{7,8}[-]{0,1}[0-9K]$/i.test(e)){return{meta:{},valid:false}}let t=e.replace(/-/g,"");while(t.length<9){t=`0${t}`}const l=[3,2,7,6,5,4,3,2];let a=0;for(let e=0;e<8;e++){a+=parseInt(t.charAt(e),10)*l[e]}a=11-a%11;let r=`${a}`;if(a===11){r="0"}else if(a===10){r="K"}return{meta:{},valid:r===t.charAt(8).toUpperCase()}}