export const fields = [
  { key: "user_id", label: "User Id", required: 1, placeholder: "Enter User Id", type: "text", isString: false },
  { key: "front_id", label: "Front Id", required: 1, placeholder: "Enter Front Id", type: "text", isString: false },
  { key: "back_id", label: "Back Id", required: 1, placeholder: "Enter Back Id", type: "text", isString: false },
  { key: "face", label: "Face", required: 1, placeholder: "Enter Face", type: "text", isString: false },
  { key: "status", label: "Status", required: 1, placeholder: "Enter Status", type: "select", isString: false,
      options: [
    {
        "value": "pending",
        "label": "Pending"
    },
    {
        "value": "approved",
        "label": "Approved"
    },
    {
        "value": "rejected",
        "label": "Rejected"
    }
] }
];