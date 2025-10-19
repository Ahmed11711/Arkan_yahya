export const fields = [
  { key: "name", label: "Name", required: 1, placeholder: "Enter Name", type: "text", isString: false },
  { key: "desc", label: "Desc", required: 1, placeholder: "Enter Desc", type: "textarea", isString: false },
  { key: "amount", label: "Amount", required: 1, placeholder: "Enter Amount", type: "number", isString: false },
  { key: "profit_rate", label: "Profit Rate", required: 1, placeholder: "Enter Profit Rate", type: "number", isString: false },
  { key: "profit_cycle", label: "Profit Cycle", required: 1, placeholder: "Enter Profit Cycle", type: "text", isString: false },
  { key: "duration_months", label: "Duration Months", required: 1, placeholder: "Enter Duration Months", type: "text", isString: false },
  { key: "capital_return", label: "Capital Return", required: 1, placeholder: "Enter Capital Return", type: "boolean", isString: false },
  { key: "affiliate_commission_rate", label: "Affiliate Commission Rate", required: 1, placeholder: "Enter Affiliate Commission Rate", type: "number", isString: false },
  { key: "status", label: "Status", required: 1, placeholder: "Enter Status", type: "select", isString: false,
      options: [
    {
        "value": "active",
        "label": "Active"
    },
    {
        "value": "completed",
        "label": "Completed"
    },
    {
        "value": "pending",
        "label": "Pending"
    }
] },
  { key: "early_withdraw_penalty", label: "Early Withdraw Penalty", required: 1, placeholder: "Enter Early Withdraw Penalty", type: "number", isString: false },
  { key: "img", label: "Img", required: 1, placeholder: "Enter Img", type: "image", isString: true },
  { key: "service_id", label: "Service Id", required: 1, placeholder: "Enter Service Id", type: "text", isString: false }
];