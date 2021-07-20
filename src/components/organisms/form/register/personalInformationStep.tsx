// Utils & Config
import React from 'react';
import { createStyles, Theme, makeStyles, useTheme } from '@material-ui/core/styles';

// External Components
import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';
import Checkbox from '@material-ui/core/Checkbox';
import FormControlLabel from '@material-ui/core/FormControlLabel';

// Internal Components
import TitleWithSubtitle from '../../../molecules/titleWithSubtitle'
import TextInput from '../../../atoms/inputs/textInput';
import FormButton from '../../../atoms/formButton';

const useStyles = makeStyles((theme: Theme) =>
    createStyles({

    }),
);

type FormData = {
    name: string,
    surname: string,
    phone: string,
    deliveryAddress: string,
    deliveryAddressDescription: string,
    deliveryZipCode: string,
    deliveryCity: string,
    hasDifferentBillingAddress: boolean,
    billingName: string,
    billingSurname: string,
    billingAddress: string,
    billingAddressDescription: string,
    billingZipCode: string,
    billingCity: string,
}

type PersonalInformationStepProps = {
    data: FormData,
    handleChangeInput: (event: React.ChangeEvent<HTMLInputElement>) => void,
    handleChangeBillingCheckbox: (event: React.ChangeEvent<HTMLInputElement>) => void,
    handleSubmitPersonalInformationData: () => void

}

const PersonalInformationStep = (props: PersonalInformationStepProps) => {
    const classes = useStyles();
    const theme = useTheme();

    return (
        <Grid container spacing={2}>
            <Grid item xs={12} style={{ marginBottom: theme.spacing(3) }}>
                <TitleWithSubtitle title='Completa tu información personal' subtitle='Por única vez' />
            </Grid>
            <Grid item xs={12}>
                <Typography>
                    Datos personales
                </Typography>
            </Grid>
            <Grid item xs={6}>
                <TextInput name='name' value={props.data.name} label='Nombre' handleChange={props.handleChangeInput} />
            </Grid>
            <Grid item xs={6}>
                <TextInput name='surname' value={props.data.surname} label='Apellido/s' handleChange={props.handleChangeInput} />
            </Grid>
            <Grid item xs={12}>
                <TextInput name='phone' value={props.data.phone} label='Número de teléfono' handleChange={props.handleChangeInput} />
            </Grid>
            <Grid item xs={12} style={{ marginTop: theme.spacing(2) }}>
                <Typography>
                    Información de entrega
                </Typography>
            </Grid>
            <Grid item xs={12}>
                <TextInput name='deliveryAddress' value={props.data.deliveryAddress} label='Dirección' handleChange={props.handleChangeInput} />
            </Grid>
            <Grid item xs={12}>
                <TextInput name='deliveryAddressDescription' value={props.data.deliveryAddressDescription} label='Piso / puerta / aclaraciones' handleChange={props.handleChangeInput} />
            </Grid>
            <Grid item xs={6}>
                <TextInput name='deliveryZipCode' value={props.data.deliveryZipCode} label='Código postal' handleChange={props.handleChangeInput} />
            </Grid>
            <Grid item xs={6}>
                <TextInput name='deliveryCity' value={props.data.deliveryCity} label='Ciudad' handleChange={props.handleChangeInput} />
            </Grid>
            <Grid item xs={12} style={{ marginTop: theme.spacing(2) }}>
                <FormControlLabel
                    control={<Checkbox checked={props.data.hasDifferentBillingAddress} onChange={props.handleChangeBillingCheckbox} name="checkedA" />}
                    label="Mis datos de facturación son diferentes"
                />
            </Grid>
            {props.data.hasDifferentBillingAddress && (
                <>
                    <Grid item xs={12}>
                        <Typography>
                            Información de facturación
                        </Typography>
                    </Grid>
                    <Grid item xs={6}>
                        <TextInput name='billingName' value={props.data.billingName} label='Nombre' handleChange={props.handleChangeInput} />
                    </Grid>
                    <Grid item xs={6}>
                        <TextInput name='billingSurname' value={props.data.billingSurname} label='Apellido/s' handleChange={props.handleChangeInput} />
                    </Grid>
                    <Grid item xs={12}>
                        <TextInput name='billingAddress' value={props.data.billingAddress} label='Dirección de facturación' handleChange={props.handleChangeInput} />
                    </Grid>
                    <Grid item xs={12}>
                        <TextInput name='billingAddressDescription' value={props.data.billingAddressDescription} label='Piso / puerta / aclaraciones' handleChange={props.handleChangeInput} />
                    </Grid>
                    <Grid item xs={6}>
                        <TextInput name='billingZipCode' value={props.data.billingZipCode} label='Código postal' handleChange={props.handleChangeInput} />
                    </Grid>
                    <Grid item xs={6}>
                        <TextInput name='billingCity' value={props.data.billingCity} label='Ciudad' handleChange={props.handleChangeInput} />
                    </Grid>
                </>
            )}
            <Grid item xs={12} style={{ marginTop: theme.spacing(2) }}>
                <FormButton text='Continuar y pagar' handleClick={props.handleSubmitPersonalInformationData} />
            </Grid>
        </Grid>
    );
}

export default PersonalInformationStep;