export const fields = [
  { key: "user_id", label: "User Id", required: 1, placeholder: "Enter User Id", type: "text", isString: false },
  { key: "transaction_id", label: "Transaction Id", required: 1, placeholder: "Enter Transaction Id", type: "text", isString: false },
  { key: "address", label: "Address", required: 1, placeholder: "Enter Address", type: "text", isString: false },
  { key: "symbol", label: "Symbol", required: 1, placeholder: "Enter Symbol", type: "text", isString: false },
  { key: "amount", label: "Amount", required: 1, placeholder: "Enter Amount", type: "number", isString: false },
  { key: "status", label: "Status", required: 1, placeholder: "Enter Status", type: "select", isString: false,
      options: [
    {
        "value": "pending",
        "label": "Pending"
    },
    {
        "value": "completed",
        "label": "Completed"
    },
    {
        "value": "failed",
        "label": "Failed"
    }
] }
];