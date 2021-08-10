// Utils & Config
import React from 'react';
import { createStyles, Theme, makeStyles, useTheme } from '@material-ui/core/styles';

// External Components
import Grid from '@material-ui/core/Grid';

// Internal Components
import TitleWithSubtitle from '../../../molecules/titleWithSubtitle'
import TextInput from '../../../atoms/inputs/textInput';
import FormButton from '../../../atoms/formButton';

const useStyles = makeStyles((theme: Theme) =>
    createStyles({

    }),
);

type FormData = {
    cardNumber: string,
    cardExpiration: string,
    cardSecurityNumber: string,
}

type PaymentStepProps = {
    data: FormData,
    handleChangeInput: (event: React.ChangeEvent<HTMLInputElement>) => void,
    handleSubmitPayment: () => void
}

const PaymentStep = (props: PaymentStepProps) => {
    const classes = useStyles();
    const theme = useTheme();

    return (
        <Grid container spacing={2}>
            <Grid item xs={12} style={{ marginBottom: theme.spacing(3) }}>
                <TitleWithSubtitle title='Ingresa tu tarjeta preferida' subtitle='Guardaremos los datos de forma segura para tus próximas compras' />
            </Grid>
            <Grid item xs={12}>
                <TextInput name='cardNumber' value={props.data.cardNumber} label='Número de tarjeta' handleChange={props.handleChangeInput} />
            </Grid>
            <Grid item xs={12}>
                <TextInput name='cardExpiration' value={props.data.cardExpiration} label='MM/AA' handleChange={props.handleChangeInput} />
            </Grid>
            <Grid item xs={12}>
                <TextInput name='cardSecurityNumber' value={props.data.cardSecurityNumber} label='Código de seguridad' handleChange={props.handleChangeInput} />
            </Grid>
            <Grid item xs={12} style={{ marginTop: theme.spacing(2) }}>
                <FormButton text='Pagar' handleClick={props.handleSubmitPayment} />
            </Grid>
        </Grid>
    );
}

export default PaymentStep;