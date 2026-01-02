export const validateForm = (values, schema) => {
    const errors = {};

    for (const field in schema) {
        const value = values[field];
        const rules = schema[field];

        for (const rule of rules) {
            const error = rule(value);
            if (error) {
                errors[field] = error;
                break; // stop di error pertama
            }
        }
    }

    return errors;
};
