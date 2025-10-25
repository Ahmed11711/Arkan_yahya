export const fields = [
  { key: "user_id", label: "User Id", required: 1, placeholder: "Enter User Id", type: "text", isString: false },
  { key: "type", label: "Type", required: 1, placeholder: "Enter Type", type: "select", isString: false,
      options: [
    {
        "value": "withdraw",
        "label": "Withdraw"
    },
    {
        "value": "deposit",
        "label": "Deposit"
    },
    {
        "value": "affiliate",
        "label": "Affiliate"
    },
    {
        "value": "plan",
        "label": "Plan"
    }
] },
  { key: "type_id", label: "Type Id", required: 1, placeholder: "Enter Type Id", type: "text", isString: false },
  { key: "amount", label: "Amount", required: 1, placeholder: "Enter Amount", type: "text", isString: false }
];