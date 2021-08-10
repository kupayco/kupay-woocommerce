// Utils & Config
import React, { useState } from 'react'

// External Components
import Button from '@material-ui/core/Button';

// Internal Components
import Modal from '../../molecules/modal';
import CtaButton from '../../atoms/ctaButton';
import Form from '../../organisms/form';

const PaymentPage = () => {
    const [open, setOpen] = useState(false);

    const handleClickOpen = () => {
        setOpen(true);
    };

    const handleClose = () => {
        setOpen(false);
    };

    return (
        <>
            <CtaButton text='Pagar con KuPay' handleClick={handleClickOpen} />
            <Form open={open} handleClose={handleClose} />
        </>
    )
}

export default PaymentPage;