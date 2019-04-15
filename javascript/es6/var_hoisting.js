var main = function() { 
   for(var x = 0;x<5;x++) { 
      console.log(x); 
   } 
   console.log("x can be accessed outside the block scope x value is :"+x); 
   console.log('x is hoisted to the function scope'); 
} 
main();

function add(a, b = 1) {
   return a+b;
}
console.log(add(4));

function fun1(...params) {
       console.log(params.length);
    }
    fun1();
    fun1(5);
    fun1(5, 6, 7);
