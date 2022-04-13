const stripePK = "PK_TEST_KEY";

const stripe = Stripe(stripePK);

const btn = document.querySelector("#btn");

//this is coming from UI but for demo purpose it is hard coded
//you can change the parameters for testing
const product = {
  name: "apple",
  desc: "Laptop",
  amount: 250000,
  quantity: 1,
};
//I only need the product info and the
// rest will be created once the payment is successful
//for demo, the function is anomymous
//typscript function will be at the bottom and in comment
btn.addEventListener("click", () => {
  fetch(`/checkout.php?amount=${product.amount}&qty=${product.quantity}&desc=${product.desc}&name=${product.name}`, {
    method: "POST",
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (session) {
      return stripe.redirectToCheckout({ sessionId: session.id });
    })
    .then(function (result) {
      if (result.error) {
        alert(result.error.message);
      }
    });
});

//TYPESCRIPT FUNCTION
// interface Product {
//   name: string;
//   desc: string;
//   amount: number;
//   quantity: number;
// }

// function getProduct(product: Product) {
//   fetch(`/checkout.php?amount=${product.amount}&qty=${product.quantity}&desc=${product.desc}&name=${product.name}`, {
//     method: "POST",
//   })
//     .then(function (response) {
//       return response.json();
//     })
//     .then(function (session) {
//       return stripe.redirectToCheckout({ sessionId: session.id });
//     })
//     .then(function (result) {
//       if (result.error) {
//         alert(result.error.message);
//       }
//     });
// }
