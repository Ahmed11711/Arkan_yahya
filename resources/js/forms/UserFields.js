export const fields = [
  { key: "name", label: "Name", required: 1, placeholder: "Enter Name", type: "text", isString: false },
  { key: "email", label: "Email", required: 1, placeholder: "Enter Email", type: "text", isString: false },
  { key: "email_verified_at", label: "Email Verified At", required: 1, placeholder: "Enter Email Verified At", type: "text", isString: false },
  { key: "password", label: "Password", required: 1, placeholder: "Enter Password", type: "password", isString: false },
  { key: "phone", label: "Phone", required: 1, placeholder: "Enter Phone", type: "text", isString: false },
  { key: "affiliate_code", label: "Affiliate Code", required: 1, placeholder: "Enter Affiliate Code", type: "text", isString: false },
  { key: "coming_affiliate", label: "Coming Affiliate", required: 1, placeholder: "Enter Coming Affiliate", type: "text", isString: false },
  { key: "active", label: "Active", required: 1, placeholder: "Enter Active", type: "boolean", isString: false },
  { key: "verified_kyc", label: "Verified Kyc", required: 1, placeholder: "Enter Verified Kyc", type: "boolean", isString: false },
  { key: "type", label: "Type", required: 1, placeholder: "Enter Type", type: "select", isString: false,
      options: [
    {
        "value": "user",
        "label": "User"
    },
    {
        "value": "guest",
        "label": "Guest"
    },
    {
        "value": "admin",
        "label": "Admin"
    }
] },
  { key: "remember_token", label: "Remember Token", required: 1, placeholder: "Enter Remember Token", type: "text", isString: false }
];