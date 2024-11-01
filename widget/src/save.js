import { useBlockProps } from "@wordpress/block-editor";

export default function save({ attributes }) {
	const blockProps = useBlockProps.save();
	let shortcodeString = "[spothit_short";

	let formTitle = replaceCharacters(attributes.text_title);
	let formDescription = replaceCharacters(attributes.text_description);
	let formFirstname = [
		attributes.form_firstname,
		replaceCharacters(attributes.text_firstname),
	];
	let formLastname = [
		attributes.form_lastname,
		replaceCharacters(attributes.text_lastname),
	];
	let formPhone = [
		attributes.form_phone,
		replaceCharacters(attributes.text_phone),
	];
	let formEmail = [attributes.form_email, attributes.text_email];
	let formStyle = attributes.form_style;
	let formSubmit = replaceCharacters(attributes.text_submit);

	console.log(formTitle);
	if (formTitle) {
		shortcodeString = shortcodeString + ` title ="${formTitle}"`;
	}
	if (formDescription) {
		shortcodeString = shortcodeString + ` description ="${formDescription}"`;
	}
	if (formFirstname[0]) {
		shortcodeString = shortcodeString + ` firstname ="${formFirstname[1]}"`;
	}
	if (formLastname[0]) {
		shortcodeString = shortcodeString + ` lastname ="${formLastname[1]}"`;
	}
	if (formPhone[0]) {
		shortcodeString = shortcodeString + ` phone ="${formPhone[1]}"`;
	}
	if (formEmail[0]) {
		shortcodeString = shortcodeString + ` email ="${formEmail[1]}"`;
	}

	shortcodeString =
		shortcodeString + ` style ="${formStyle}" submit="${formSubmit}"`;

	shortcodeString = shortcodeString + "][/spothit_short]";

	function replaceCharacters(str) {
		str = str.replaceAll("<", "!/%%?");
		str = str.replaceAll(">", "!//%%?");
		str = str.replaceAll('"', "!|%%?");
		str = str.replaceAll("'", "!||%%?");
		str = str.replaceAll("`", "!_|%%?");
		str = str.replaceAll(" ", "!__%%?");
		return str;
	}

	return <div {...blockProps}>{shortcodeString}</div>;
}
