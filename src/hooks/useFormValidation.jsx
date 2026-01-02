import { useState } from "react";
import { validateForm } from "../utils/validators/validateForm";

export function useFormValidation(initialValues, schema) {
    const [values, setValues] = useState(initialValues);
    const [errors, setErrors] = useState({});

    const handleChange = (field, value) => {
        setValues(prev => ({ ...prev, [field]: value }));
        setErrors(prev => ({ ...prev, [field]: null }));
    };

    const validate = () => {
        const validationErrors = validateForm(values, schema);
        setErrors(validationErrors);
        return Object.keys(validationErrors).length === 0;
    };

    return {
        values,
        errors,
        handleChange,
        validate,
    };
}
