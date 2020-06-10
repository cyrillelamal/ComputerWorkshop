import React from "react";

const Person = ({name}) => (
    <li>
        <strong>{name.toUpperCase()}</strong> <span>{'🟊'.repeat(name.length)}</span>
    </li>
);

export default Person;
