import React, {useState} from 'react';
import { StatusBar } from 'expo-status-bar';

import { Formik } from 'formik';
import { View, ActivityIndicator } from 'react-native';

//icons
import {Octicons, Ionicons, Fontisto} from '@expo/vector-icons';

import{
    StyledContainer,
    InnerContainer,
    PageLogo,
    PageTitle,
    SubTitle,
    StyledFormArea,
    LeftIcon,
    RightIcon,
    StyledButton,
    StyledInputLabel,
    StyledTextInput,
    ButtonText,
    Colors,
    MsgBox,
    Line,
    ExtraText,
    ExtraView,
    TextLink,
    TextLinkContent,
} from './../compontents/styles';

const {brand, darkLight, primary} = Colors;

import KeyboardAvoidingWrapper from '../compontents/KeyboardAvoidingWrapper';

import axios from 'axios';

const Login = ({navigation}) => {
    const [hidePassword, setHidePassword] = useState(true);
    const [message, setMessage] = useState();
    const [messageType, setMessageType] = useState();

    const handleLogin = (credentials, setSubmitting) => {
        handleMessage(null);
        const url = 'http://192.168.26.218/Integralt/loginreg.php?op=signin';

        axios
        .post(url, credentials)
        .then((response) => {
                const result = response.data;
                const {message, status, data} = result;

                if(status !== 'SUCCESS'){
                    handleMessage(message, status);
                }else if(data[0]['user_type'] == 'admin'){
                    navigation.navigate('Front', { ...data[0] });
                }else{
                    navigation.navigate("Welcome", {...data[0]});
                }
                setSubmitting(false);
        })
        .catch(error=> {
            console.log(error.JSON());
            setSubmitting(false);
            handleMessage("Error! Ellenőrizze az internet kapcsolatát!");
        });
    };
    const handleMessage = (message, type = 'FAILED') => {
        setMessage(message);
        setMessageType(type);
    }

    return(
        <KeyboardAvoidingWrapper>
        <StyledContainer>
            <StatusBar style="dark"/>
            <InnerContainer>
                <PageLogo resizeMode="cover" source={require('./../assets/img/StormSite.png')}/>
                <PageTitle>StormSite</PageTitle>
                <SubTitle>Bejelentkezés</SubTitle>

                <Formik
                initialValues={{email: '', no_hash: ''}}
                onSubmit={(values, {setSubmitting}) =>{
                    if(values.email== '' || values.no_hash == ''){
                        handleMessage('Kérlek tölts ki minden mezőt!');
                        setSubmitting(false);
                    }else{
                        handleLogin(values, setSubmitting);
                    }
                }}
                >{({handleChange, handleBlur, handleSubmit, values, isSubmitting})=> (<StyledFormArea>
                        <MyTextInput
                        label="Email"
                        icon="mail"
                        placeholder="Ezekiel@gmail.com"
                        placeholderTextColor={darkLight}
                        onChangeText={handleChange('email')}
                        onBlur={handleBlur('email')}
                        value={values.email}
                        keyboardType="email-address"
                        />

                        <MyTextInput
                        label="Jelszó"
                        icon="lock"
                        placeholder="* * * * * * * *"
                        placeholderTextColor={darkLight}
                        onChangeText={handleChange('no_hash')}
                        onBlur={handleBlur('no_hash')}
                        value={values.no_hash}
                        secureTextEntry={hidePassword}
                        isPassword={true}
                        hidePassword={hidePassword}
                        setHidePassword={setHidePassword}
                        />
                        <MsgBox type={messageType}>{message}</MsgBox>

                        {!isSubmitting &&
                        <StyledButton onPress={handleSubmit}>
                            <ButtonText>
                                Bejelentkezés
                            </ButtonText>
                        </StyledButton>}

                        {isSubmitting &&
                        <StyledButton disabled={true}>
                            <ActivityIndicator size="large" color={primary}/>
                        </StyledButton>}

                        <Line />
                        <StyledButton  google={true} onPress={handleSubmit}>
                            <Fontisto name='google' color={primary} size={25}/>
                            <ButtonText  google={true}>
                                Belépés Google fiókkal
                            </ButtonText>
                        </StyledButton>

                        <ExtraView>
                            <ExtraText>
                                Nincs még fiókja?
                            </ExtraText>
                            <TextLink onPress={()=> navigation.navigate("Signup")}>
                                <TextLinkContent>
                                    Regisztrálj
                                </TextLinkContent>
                            </TextLink>
                        </ExtraView>

                </StyledFormArea>)}

                </Formik>
            </InnerContainer>
        </StyledContainer>
        </KeyboardAvoidingWrapper>
    );
};

const MyTextInput = ({label, icon, isPassword, hidePassword, setHidePassword, ...props}) => {

    return(
        <View>
        <LeftIcon>
            <Octicons name={icon} size={30} color={brand} />
        </LeftIcon>
        <StyledInputLabel>{label}</StyledInputLabel>
        <StyledTextInput {...props} />
        {isPassword && (
            <RightIcon onPress={()=> setHidePassword(!hidePassword)}>
                <Ionicons name={hidePassword ? 'md-eye-off' : 'md-eye'} size={30} color={darkLight}/>
            </RightIcon>
        )}
        </View>);
};

export default Login;