// Utils & Config
import React, { useState, useEffect } from 'react'

// External Components
import Button from '@material-ui/core/Button';

// Internal Components
import Modal from '../../molecules/modal';
import AccessDataStep from './register/accessDataStep';
import PersonalInformationStep from './register/personalInformationStep';
import PaymentStep from './register/paymentStep';

type FormProps = {
    open: boolean,
    handleClose: any
}

const Form = (props: FormProps) => {
    const [open, setOpen] = useState(false);
    const [accessData, setAccessData] = useState({
        email: '',
        password: ''
    })
    const [personalInformationData, setPersonalInformationData] = useState({
        name: '',
        surname: '',
        phone: '',
        deliveryAddress: '',
        deliveryAddressDescription: '',
        deliveryZipCode: '',
        deliveryCity: '',
        hasDifferentBillingAddress: false,
        billingName: '',
        billingSurname: '',
        billingAddress: '',
        billingAddressDescription: '',
        billingZipCode: '',
        billingCity: '',

    })
    const [paymentData, setPaymentData] = useState({
        cardNumber: 0,
        cardExpiration: '',
        cardSecurityNumber: 0,
    })
    const [registrationStep, setRegistrationStep] = useState(1);

    useEffect(() => {
        setRegistrationStep(1)
        setAccessData({
            ...accessData,
            email: '',
            password: ''
        })
        setPersonalInformationData({
            ...personalInformationData,
            name: '',
            surname: '',
            phone: '',
            deliveryAddress: '',
            deliveryAddressDescription: '',
            deliveryZipCode: '',
            deliveryCity: '',
            hasDifferentBillingAddress: false,
            billingName: '',
            billingSurname: '',
            billingAddress: '',
            billingAddressDescription: '',
            billingZipCode: '',
            billingCity: '',
        })
    }, [props.open]);

    const handleChangeInputAccessStep = (event: React.ChangeEvent<HTMLInputElement>) => {
        const name = event.target.name;
        const value = event.target.value;
        setAccessData({
            ...accessData,
            [name]: value,
        })
    }

    const handleChangeInputPersonalInformationDataStep = (event: React.ChangeEvent<HTMLInputElement>) => {
        const name = event.target.name;
        const value = event.target.value;
        setPersonalInformationData({
            ...personalInformationData,
            [name]: value,
        })
    }

    const handleChangeInputPaymentStep = (event: React.ChangeEvent<HTMLInputElement>) => {
        const name = event.target.name;
        const value = event.target.value;
        setPaymentData({
            ...paymentData,
            [name]: value,
        })
    }

    const handleChangeBillingCheckbox = (event: React.ChangeEvent<HTMLInputElement>) => {
        setPersonalInformationData({
            ...personalInformationData,
            hasDifferentBillingAddress: event.target.checked,
            billingName: '',
            billingSurname: '',
            billingAddress: '',
            billingAddressDescription: '',
            billingZipCode: '',
            billingCity: '',
        });
    };

    const handleChangeStep = (actualStep: number, direction: number) => {
        let newStep = actualStep + direction;
        setRegistrationStep(newStep)
    }

    const handleSubmitAccessData = () => {
        alert(`data: ${JSON.stringify(accessData)}`);
        handleChangeStep(registrationStep, 1);
        setAccessData({
            ...accessData,
            email: '',
            password: ''
        })
    }

    const handleSubmitPersonalInformationData = () => {
        if (!personalInformationData.hasDifferentBillingAddress) {
            setPersonalInformationData({
                ...personalInformationData,
                billingName: personalInformationData.name,
                billingSurname: personalInformationData.surname,
                billingAddress: personalInformationData.deliveryAddress,
                billingAddressDescription: personalInformationData.deliveryAddressDescription,
                billingZipCode: personalInformationData.deliveryZipCode,
                billingCity: personalInformationData.deliveryCity,
            });
        }
        alert(`data: ${JSON.stringify(personalInformationData)}`);
        handleChangeStep(registrationStep, 1);
        setPersonalInformationData({
            ...personalInformationData,
            name: '',
            surname: '',
            phone: '',
            deliveryAddress: '',
            deliveryAddressDescription: '',
            deliveryZipCode: '',
            deliveryCity: '',
            hasDifferentBillingAddress: false,
            billingName: '',
            billingSurname: '',
            billingAddress: '',
            billingAddressDescription: '',
            billingZipCode: '',
            billingCity: '',
        })
    }

    const handleSubmitPayment = () => {
        alert(`data: ${JSON.stringify(paymentData)}`);
        setPaymentData({
            cardNumber: 0,
            cardExpiration: '',
            cardSecurityNumber: 0,
        })
        props.handleClose();
    }

    let stepComponent;
    switch (registrationStep) {
        case 1:
            stepComponent = <AccessDataStep data={accessData} handleChangeInput={handleChangeInputAccessStep} handleSubmitAccessData={handleSubmitAccessData} />;
            break;
        case 2:
            stepComponent = <PersonalInformationStep data={personalInformationData} handleChangeInput={handleChangeInputPersonalInformationDataStep} handleChangeBillingCheckbox={handleChangeBillingCheckbox} handleSubmitPersonalInformationData={handleSubmitPersonalInformationData} />
            break;
        case 3:
            stepComponent = <PaymentStep data={paymentData} handleChangeInput={handleChangeInputPaymentStep} handleSubmitPayment={handleSubmitPayment} />
            break;
        default:
            stepComponent = <AccessDataStep data={accessData} handleChangeInput={handleChangeInputAccessStep} handleSubmitAccessData={handleSubmitAccessData} />;
            break;
    }

    return (
        <Modal title='Pagar con KuPay' open={props.open} handleClose={props.handleClose}>
            {stepComponent}
        </Modal>
    )
}

export default Form;