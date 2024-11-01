import { registerBlockType } from "@wordpress/blocks";

import "./style.scss";

import Edit from "./edit";
import save from "./save";
// import metadata from "./block.json";

registerBlockType("spothit/widget", {
	title: "Spot-Hit contact form",
	category: "widgets",
	description:
		"Spot-Hit form, allowing the registration of users in your Spot-Hit contacts.",
	attributes: {
		form_firstname: {
			type: "boolean",
			default: true,
		},
		form_lastname: {
			type: "boolean",
			default: true,
		},
		form_phone: {
			type: "boolean",
			default: true,
		},
		form_email: {
			type: "boolean",
			default: true,
		},
		form_style: {
			type: "string",
			default: "light",
		},
		text_title: {
			type: "string",
			default: "Title",
		},
		text_description: {
			type: "string",
			default: "Description",
		},
		text_firstname: {
			type: "string",
			default: "Firstname",
		},
		text_lastname: {
			type: "string",
			default: "Lastname",
		},
		text_phone: {
			type: "string",
			default: "Phone number",
		},
		text_email: {
			type: "string",
			default: "Email address",
		},
		text_submit: {
			type: "string",
			default: "Submit",
		},
	},
	textdomain: "spothit",
	editorScript: "file:./index.js",
	editorStyle: "file:./index.css",
	style: "file:./style-index.css",

	edit: Edit,

	save,
});
