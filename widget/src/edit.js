import { useState, useEffect } from "@wordpress/element";
import {
	useBlockProps,
	InspectorControls,
	RichText,
} from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import {
	Button,
	Modal,
	PanelBody,
	CheckboxControl,
	__experimentalRadio as Radio,
	__experimentalRadioGroup as RadioGroup,
} from "@wordpress/components";

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps();
	const [modal, setModal] = useState(false);
	const openModal = () => setModal(true);
	const closeModal = () => setModal(false);

	function isElementActive(param, isActive) {
		let el = String(`[data-spotfield="` + param + `"]`);
		if (!isActive) {
			document.querySelector(el).style.display = "none";
		} else {
			document.querySelector(el).style.display = "block";
		}
	}

	useEffect(() => {
		isElementActive("firstname", attributes.form_firstname);
		isElementActive("lastname", attributes.form_lastname);
		isElementActive("phone", attributes.form_phone);
		isElementActive("email", attributes.form_email);
	}, []);

	useEffect(() => {
		if (attributes.form_phone === false && attributes.form_email === false) {
			openModal();
			setAttributes({ form_phone: true });
			document.querySelector('[data-spotfield="phone"]').style.display =
				"block";
		}
	}, [
		attributes.form_firstname,
		attributes.form_lastname,
		attributes.form_phone,
		attributes.form_email,
	]);

	return (
		<>
			<InspectorControls>
				<PanelBody
					title="Title, description and Submit button"
					initialOpen={false}
				>
					<p>
						To modify the title, the description or the send button, click
						directly on the element and write the text. Leave the field blank to
						not display it.
					</p>
				</PanelBody>

				<PanelBody title="Required fields" initialOpen={false}>
					<p>Select the fields that will be required in the form.</p>
					<CheckboxControl
						label="Firstname"
						help="Add the firstname field ?"
						onChange={() => {
							setAttributes({ form_firstname: !attributes.form_firstname });
							isElementActive("firstname", !attributes.form_firstname);
						}}
						checked={attributes.form_firstname}
					/>
					<CheckboxControl
						label="Lastname"
						help="Add the lastname field ?"
						onChange={() => {
							setAttributes({ form_lastname: !attributes.form_lastname });
							isElementActive("lastname", !attributes.form_lastname);
						}}
						checked={attributes.form_lastname}
					/>
					<CheckboxControl
						label="Phone number"
						help="Add the phone number field ?"
						onChange={() => {
							setAttributes({ form_phone: !attributes.form_phone });
							isElementActive("phone", !attributes.form_phone);
						}}
						checked={attributes.form_phone}
					/>
					<CheckboxControl
						label="Email address"
						help="Add the email address field ?"
						onChange={() => {
							setAttributes({ form_email: !attributes.form_email });
							isElementActive("email", !attributes.form_email);
						}}
						checked={attributes.form_email}
					/>
				</PanelBody>
				<PanelBody title="Form style" initialOpen={false}>
					<RadioGroup
						label="style"
						onChange={(e) => {
							console.log(e);
							setAttributes({ form_style: e });
						}}
						checked={attributes.form_style}
					>
						<Radio value="light">Light</Radio>
						<Radio value="dark">Dark</Radio>
					</RadioGroup>
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<div className="container">
					<section
						id="spothit_widget"
						className={
							`col-md-8 col-sm-12 offset-md-2 p-3 section-` +
							attributes.form_style
						}
					>
						<div class="container">
							<div class="row">
								<div class="col-md-12 mb-3">
									<div class="row">
										<div class="section-title col-md-12 mb-2">
											<RichText
												tagName="h2"
												placeholder={"Title"}
												value={attributes.text_title}
												className="section-title"
												onChange={(e) => setAttributes({ text_title: e })}
											/>
										</div>
									</div>
									<div class="row">
										<RichText
											tagName="div"
											placeholder={"Description"}
											id="spot-section-description"
											value={attributes.text_description}
											className="col-md-12"
											onChange={(e) => setAttributes({ text_description: e })}
										/>
									</div>
								</div>
							</div>
							<div id="spot_fields_block" class="col-md-12">
								<form id="spothit_widget_form">
									<div
										class="form-group label-floating"
										data-spotfield="firstname"
									>
										<RichText
											tagName="label"
											value={attributes.text_firstname}
											className="control-label"
											onChange={(e) => setAttributes({ text_firstname: e })}
											style={{ cursor: "text" }}
										/>
										<input class="form-control" type="text" name="firstname" />
										<div class="help-block error_msg"></div>
									</div>

									<div
										class="form-group label-floating"
										data-spotfield="lastname"
									>
										<RichText
											tagName="label"
											value={attributes.text_lastname}
											className="control-label"
											onChange={(e) => setAttributes({ text_lastname: e })}
											style={{ cursor: "text" }}
										/>
										<input class="form-control" type="text" name="lastname" />
										<div class="help-block error_msg"></div>
									</div>
									<div class="form-group label-floating" data-spotfield="email">
										<RichText
											tagName="label"
											value={attributes.text_email}
											className="control-label"
											onChange={(e) => setAttributes({ text_email: e })}
											style={{ cursor: "text" }}
										/>
										<input class="form-control" type="email" name="email" />
										<div class="help-block error_msg"></div>
									</div>
									<div class="form-group label-floating" data-spotfield="phone">
										<RichText
											tagName="label"
											value={attributes.text_phone}
											className="control-label"
											onChange={(e) => setAttributes({ text_phone: e })}
											style={{ cursor: "text" }}
										/>
										<input class="form-control" type="text" name="mobile" />
										<div class="help-block error_msg"></div>
									</div>
									<div class="form-submit mt-5">
										<RichText
											tagName="button"
											id="spot_submit_btn"
											value={attributes.text_submit}
											className="btn btn-common w-100"
											onChange={(e) =>
												setAttributes({ text_submit: attributes.text_submit })
											}
											onClick={(e) => e.preventDefault()}
											onSubmit={(e) => e.preventDefault()}
											style={{ cursor: "text" }}
										/>
										<div class="clearfix"></div>
									</div>
								</form>
							</div>
						</div>
					</section>
				</div>
			</div>

			<div class="d-flex w-100 flex-column justify-content-center text-center">
				<i class="fa-regular fa-circle-info fa-lg"></i>

				<p class="col-md-8 col-sm-12 offset-md-2 text-center">
					You can edit field labels, title and description by clicking on them
				</p>
			</div>

			{modal && (
				<Modal title="Spot-Hit" onRequestClose={closeModal}>
					<p>The form requires the SMS or Email field at least.</p>
					<Button variant="secondary" onClick={closeModal}>
						Close
					</Button>
				</Modal>
			)}
		</>
	);
}
